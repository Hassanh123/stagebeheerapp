<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Student;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Toon alle beschikbare stages op de homepage
     */
    public function index()
    {
        // Haal alle stages op met tags, teacher en company
        $stages = Stage::with(['tags', 'teacher', 'company'])->get();

        return view('home', compact('stages'));
    }

    /**
     * Laat een student een stage kiezen
     * 
     * @param  Request $request
     * @param  Stage $stage
     */
    public function choose(Request $request, Stage $stage)
    {
        // Valideer dat student_id is meegegeven
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::find($data['student_id']);

        // Check of student al een stage heeft gekozen
        if ($student->stage_id) {
            return back()->with('error', 'Deze student heeft al een stage gekozen.');
        }

        // Stage reserveren
        $stage->status = 'gereserveerd';
        $stage->save();

        // Koppel stage aan student
        $student->stage_id = $stage->id;
        $student->save();

        return back()->with('success', 'Stage succesvol gekozen, wacht op akkoord van docent.');
    }

    /**
     * Toon de keuze van een student (inclusief gekoppelde docent en bedrijf)
     */
    public function mijnKeuze(Student $student)
    {
        $student->load('stage.teacher', 'stage.company');

        return view('mijn-keuze', compact('student'));
    }
}
