<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Student;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    /**
     * Toon overzicht van alle stages, inclusief eigen keuze voor studenten of gekoppelde stages voor docenten.
     */
    public function index(Request $request)
    {
        $stages = Stage::with(['company', 'teacher', 'tags'])->get();
        $tags = Tag::all();

        $user = Auth::user();
        $student = $user && $user->role === 'student' ? $user->student : null;
        $mijnKeuze = null;
        $teacherStages = collect();
        $teacherStudents = collect();

        if ($student && $student->stage_id) {
            $mijnKeuze = Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);
        }

        if ($user && $user->role === 'teacher') {
            $teacher = $user->teacher;
            if ($teacher) {
                $teacherStages = $teacher->stages()
                    ->with(['company', 'tags', 'students.user'])
                    ->get();

                $teacherStudents = $teacherStages
                    ->flatMap(fn($stage) => $stage->students ?? collect())
                    ->unique('id')
                    ->values();
            }
        }

        return view('home', compact('stages', 'mijnKeuze', 'teacherStages', 'teacherStudents', 'tags'));
    }

    /**
     * Student kiest een stage.
     */
    public function choose(Stage $stage)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'student') {
            return back()->with('error', 'Alleen studenten kunnen een stage kiezen.');
        }

        $student = $user->student;

        // Oude stage vrijgeven indien nog "in behandeling"
        if ($student->stage_id) {
            $oudeStage = Stage::find($student->stage_id);
            if ($oudeStage && $oudeStage->status === 'in_behandeling') {
                $oudeStage->status = 'vrij';
                $oudeStage->save();

                session()->flash('info', "De stage '{$oudeStage->titel}' is weer beschikbaar gesteld.");
            }
        }

        // Check of de stage nog beschikbaar is
        if (
            $stage->status === 'goedgekeurd' ||
            ($stage->status === 'in_behandeling' && $stage->students()->where('student_id', '!=', $student->id)->exists())
        ) {
            return back()->with('error', 'Deze stage is momenteel niet beschikbaar.');
        }

        // Student kiest nieuwe stage
        $stage->status = 'in_behandeling';
        $stage->save();

        $student->stage_id = $stage->id;
        $student->save();

        return back()->with('success', "⏳ Je hebt de stage '{$stage->titel}' gekozen. Deze wordt beoordeeld door de beheerder.");
    }

    /**
     * Admin keurt stage af.
     */
    public function adminReject(Stage $stage)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') abort(403);

        $student = Student::where('stage_id', $stage->id)->first();
        if (!$student) {
            return back()->with('error', 'Er is geen student gekoppeld aan deze stage.');
        }

        $stage->update([
            'status' => 'vrij',
            'teacher_id' => null,
        ]);

        $student->update(['stage_id' => null]);

        return back()->with('error', "❌ De keuze voor '{$stage->titel}' is afgekeurd. De student kan nu een nieuwe stage kiezen.");
    }

    /**
     * Admin keurt stage goed.
     */
    public function adminApprove(Stage $stage, Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') abort(403);

        $student = Student::where('stage_id', $stage->id)->first();
        if (!$student) {
            return back()->with('error', 'Er is geen student gekoppeld aan deze stage.');
        }

        // Zet andere aanvragen van dezelfde student terug naar 'vrij'
        Stage::where('id', '!=', $stage->id)
            ->where('status', 'in_behandeling')
            ->whereHas('students', fn($q) => $q->where('id', $student->id))
            ->update(['status' => 'vrij']);

        // Koppel eventueel een begeleider
        if ($request->filled('teacher_id')) {
            $stage->teacher_id = $request->teacher_id;
        }

        $stage->status = 'goedgekeurd';
        $stage->save();

        $teacherNaam = $stage->teacher?->naam ?? 'Nog niet toegewezen';

        return back()->with('success', "🎉 De keuze voor '{$stage->titel}' is goedgekeurd! Begeleider: {$teacherNaam}.");
    }
}
