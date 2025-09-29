<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
    // Laat alle stages zien
  public function index()
{
    $stages = Stage::with(['company', 'teacher', 'tags'])->get();

    $student = Auth::check() && Auth::user()->role === 'student'
        ? Auth::user()->student
        : null;

    $mijnKeuze = null;

    // Alleen ophalen als student daadwerkelijk een actieve stage heeft gekozen
    if ($student && $student->stage_id) {
        $stage = Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);

        // Alleen als status niet 'vrij' is
        if ($stage && in_array($stage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
            $mijnKeuze = $stage;
        }
    }

    return view('home', compact('stages', 'mijnKeuze'));
}

    public function choose(Stage $stage)
{
    $user = Auth::user();

    if (!$user || $user->role !== 'student') {
        return back()->with('error', 'Je bent geen student.');
    }

    $student = $user->student;

    // Check of student al een actieve keuze heeft (status in_behandeling/goedgekeurd/afgekeurd)
    if ($student->stage_id) {
        $gekozenStage = Stage::find($student->stage_id);
        if ($gekozenStage && in_array($gekozenStage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
            return back()->with('error', 'Je hebt al een stage gekozen.');
        }
    }

    if ($stage->status !== 'vrij') {
        return back()->with('error', 'Deze stage is niet beschikbaar.');
    }

    // Stage op slot zetten
    $stage->status = 'in_behandeling';
    $stage->save();

    // Koppel stage aan student
    $student->stage_id = $stage->id;
    $student->save();

    return back()->with('success', 'Je keuze is opgeslagen en wordt beoordeeld door de beheerder.');
}
    // Admin keurt stage af
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
