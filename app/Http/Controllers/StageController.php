<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Student;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    public function index(Request $request)
    {
        $stages = Stage::with(['company', 'teacher', 'tags'])->get();

        $user = Auth::user();
        $student = $user && $user->role === 'student' ? $user->student : null;
        $mijnKeuze = null;
        $notification = null;
        $teacherStages = collect();
        $teacherStudents = collect();

        /**
         * =========================
         * STUDENT
         * =========================
         */
        if ($student && $student->stage_id) {
            $stage = Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);

            if ($stage && in_array($stage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
                $mijnKeuze = $stage;

                // meest recente notificatie ophalen
                $notification = Notification::where('user_id', $user->id)
                    ->where('stage_id', $stage->id)
                    ->latest('created_at')
                    ->first();

                if ($notification) {
                    // huidige status updaten
                    $notification->status = $stage->status;

                    if (is_null($notification->read_at)) {
                        $notification->read_at = now();
                    }

                    $notification->save();
                }
            }
        }

        /**
         * =========================
         * TEACHER
         * =========================
         */
        if ($user && $user->role === 'teacher') {
            $teacher = $user->teacher;

            if ($teacher) {
                // Haal stages van deze docent via relatie
                $teacherStages = $teacher->stages()
                    ->with(['company', 'tags', 'students.user'])
                    ->get();

                // Verzamel studenten die aan deze stages gekoppeld zijn
                $teacherStudents = $teacherStages
                    ->flatMap(function ($stage) {
                        return $stage->students ?? collect();
                    })
                    ->unique('id')
                    ->values();
            }
        }

        return view('home', compact(
            'stages',
            'mijnKeuze',
            'notification',
            'teacherStages',
            'teacherStudents'
        ));
    }

    public function choose(Stage $stage)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'student') {
            return back()->with('error', 'Alleen studenten kunnen een stage kiezen.');
        }

        $student = $user->student;

        // Reset eerdere in-behandeling stage
        if ($student->stage_id) {
            $gekozenStage = Stage::find($student->stage_id);
            if ($gekozenStage && $gekozenStage->status === 'in_behandeling') {
                $gekozenStage->status = 'vrij';
                $gekozenStage->save();
            }
        }

        if ($stage->status !== 'vrij') {
            return back()->with('error', 'Deze stage is niet meer beschikbaar.');
        }

        $stage->status = 'in_behandeling';
        $stage->save();

        $student->stage_id = $stage->id;
        $student->save();

        Notification::create([
            'user_id' => $user->id,
            'stage_id' => $stage->id,
            'status' => $stage->status,
            'message' => "Je hebt een stage gekozen: '{$stage->titel}'. Deze wordt beoordeeld door de beheerder.",
        ]);

        return back();
    }

    public function adminReject(Stage $stage)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $student = Student::where('stage_id', $stage->id)->first();

        if ($student) {
            $student->stage_id = null;
            $student->save();

            Notification::create([
                'user_id' => $student->user_id,
                'stage_id' => $stage->id,
                'status' => 'afgekeurd',
                'message' => "❌ Je keuze voor '{$stage->titel}' is afgekeurd. De stage is weer vrijgegeven; kies een nieuwe stage.",
            ]);
        }

        $stage->status = 'vrij';
        $stage->teacher_id = null;
        $stage->save();

        return back()->with('error', 'Stage is afgewezen en weer vrijgegeven.');
    }

    public function adminApprove(Stage $stage, Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $student = Student::where('stage_id', $stage->id)->first();
        if (!$student) {
            return back()->with('error', 'Geen student gekoppeld aan deze stage.');
        }

        // Reset andere in-behandeling stages van deze student
        Stage::where('id', '!=', $stage->id)
            ->where('status', 'in_behandeling')
            ->whereHas('student', function($q) use ($student) {
                $q->where('id', $student->id);
            })
            ->update(['status' => 'vrij']);

        // Teacher koppelen
        if ($request->filled('teacher_id')) {
            $stage->teacher_id = $request->teacher_id;
        }

        // Stage goedkeuren
        $stage->status = 'goedgekeurd';
        $stage->save();

        Notification::create([
            'user_id' => $student->user_id,
            'stage_id' => $stage->id,
            'status' => $stage->status,
            'message' => "🎉 Je keuze voor '{$stage->titel}' is goedgekeurd. Begeleider: " . ($stage->teacher?->naam ?? 'Nog niet toegewezen') . ".",
        ]);

        return back()->with('success', 'Stage is goedgekeurd en student is op de hoogte gesteld.');
    }
}
