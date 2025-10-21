<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    /**
     * Toon alle stages
     */
    public function index()
    {
        $stages = Stage::with(['company', 'teacher', 'tags'])->get();

        $user = Auth::user();
        $student = $user && $user->role === 'student' ? $user->student : null;
        $mijnKeuze = null;

        // Controleer of student al een stage heeft gekozen
        if ($student && $student->stage_id) {
            $stage = Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);

            // Alleen tonen als de status niet 'vrij' is
            if ($stage && in_array($stage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
                $mijnKeuze = $stage;
            }
        }

        return view('home', compact('stages', 'mijnKeuze'));
    }

    /**
     * Student kiest een stage
     */
    public function choose(Stage $stage)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'student') {
            return back()->with('error', 'Alleen studenten kunnen een stage kiezen.');
        }

        $student = $user->student;

        // Check of student al een actieve keuze heeft
        if ($student->stage_id) {
            $gekozenStage = Stage::find($student->stage_id);
            if ($gekozenStage && in_array($gekozenStage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
                return back()->with('error', 'Je hebt al een stage gekozen.');
            }
        }

        // Check of de stage vrij is
        if ($stage->status !== 'vrij') {
            return back()->with('error', 'Deze stage is niet meer beschikbaar.');
        }

        // Stage op in_behandeling zetten
        $stage->status = 'in_behandeling';
        $stage->save();

        // Stage koppelen aan student
        $student->stage_id = $stage->id;
        $student->save();

        return back()->with('success', 'Je keuze is opgeslagen en wordt beoordeeld door de beheerder.');
    }

    /**
     * Admin keurt stage af
     */
    public function adminReject(Stage $stage)
    {
        $student = Student::where('stage_id', $stage->id)->first();

        if ($student) {
            $student->stage_id = null;
            $student->save();
        }

        $stage->status = 'vrij';
        $stage->save();

        return back()->with('error', 'Stage is afgewezen en weer vrijgegeven.');
    }
}
