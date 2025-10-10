<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    public function index(Request $request)
    {
        // Haal stages met filters op
        $query = Stage::with(['company', 'teacher', 'tags']);

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('naam', $request->tag));
        }

        $stages = $query->get();
        $tags = Tag::all();

        $student = Auth::user()?->role === 'student' ? Auth::user()->student : null;
        $mijnKeuze = null;
        $latestNotification = null;

        if ($student && $student->stage_id) {
            $stage = Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);

            if ($stage && in_array($stage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
                $mijnKeuze = $stage;

                // Alleen nieuwste notificatie ophalen
                $latestNotification = Notification::where('user_id', Auth::id())
                    ->where('stage_id', $stage->id)
                    ->orderByDesc('created_at')
                    ->first();
            } else {
                // Stage afgekeurd of verwijderd, student vrijmaken
                $student->stage_id = null;
                $student->save();
            }
        }

        return view('home', compact('stages', 'tags', 'mijnKeuze', 'latestNotification'));
    }

    public function choose(Stage $stage)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'student') {
            return back()->with('error', 'Alleen studenten kunnen een stage kiezen.');
        }

        $student = $user->student;

        if ($student->stage_id) {
            $huidigeStage = Stage::find($student->stage_id);
            if ($huidigeStage && in_array($huidigeStage->status, ['in_behandeling', 'goedgekeurd'])) {
                return back()->with('error', 'Je hebt al een stage gekozen.');
            }
        }

        if ($stage->status !== 'vrij') {
            return back()->with('error', 'Deze stage is niet beschikbaar.');
        }

        $stage->status = 'in_behandeling';
        $stage->save();

        $student->stage_id = $stage->id;
        $student->save();

        Notification::create([
            'user_id' => $user->id,
            'stage_id' => $stage->id,
            'status' => 'in_behandeling',
            'message' => "Je stage '{$stage->titel}' staat nu in behandeling. Wacht op goedkeuring door de beheerder.",
        ]);

        return back()->with('success', 'Je keuze is opgeslagen. Wacht op goedkeuring.');
    }

    public function adminApprove(Stage $stage, Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $teacher = Teacher::find($request->teacher_id);
        if (!$teacher) return back()->with('error', 'Ongeldige docent gekozen.');

        $stage->teacher_id = $teacher->id;
        $stage->status = 'goedgekeurd';
        $stage->save();

        $student = Student::where('stage_id', $stage->id)->first();
        if ($student) {
            Notification::updateOrCreate(
                [
                    'user_id' => $student->user_id,
                    'stage_id' => $stage->id
                ],
                [
                    'status' => 'goedgekeurd',
                    'message' => "Je keuze voor je stage '{$stage->titel}' is goedgekeurd. Begeleider: {$teacher->naam}.",
                ]
            );
        }

        return back()->with('success', 'Stage goedgekeurd.');
    }

    public function adminReject(Stage $stage)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $student = Student::where('stage_id', $stage->id)->first();

        if ($student) {
            Notification::updateOrCreate(
                [
                    'user_id' => $student->user_id,
                    'stage_id' => $stage->id
                ],
                [
                    'status' => 'afgekeurd',
                    'message' => "Je keuze voor je stage '{$stage->titel}' is afgekeurd. Kies een nieuwe stage.",
                ]
            );

            $student->stage_id = null; // student vrijmaken
            $student->save();
        }

        $stage->status = 'vrij'; // stage vrijgeven
        $stage->teacher_id = null;
        $stage->save();

        return back()->with('error', 'Stage afgekeurd en weer beschikbaar.');
    }
}
