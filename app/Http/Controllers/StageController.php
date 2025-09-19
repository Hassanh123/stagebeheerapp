<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Toon alle beschikbare stages en bedrijven op de homepage
     */
    public function index(Request $request)
    {
        // Haal alle stages op met relaties
        $stages = Stage::with(['tags', 'teacher', 'company'])->get();

        // Haal alle bedrijven op
        $companies = Company::all();

        // Haal “mijn keuze” van de student als student_id is meegegeven
        $mijnKeuze = null;
        $student_id = $request->query('student_id'); // optioneel via querystring
        if ($student_id) {
            $student = Student::find($student_id);
            if ($student && $student->stage_id) {
                $mijnKeuze = Stage::with(['teacher', 'company'])->find($student->stage_id);
            }
        }

        return view('home', compact('stages', 'companies', 'mijnKeuze', 'student_id'));
    }

    /**
     * Laat een student een stage kiezen via student_id
     */
    public function choose(Request $request, Stage $stage)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::find($data['student_id']);

        if (!$student) {
            return back()->with('error', 'Studentgegevens niet gevonden.');
        }

        if ($student->stage_id) {
            return back()->with('error', 'Deze student heeft al een stage gekozen.');
        }

        if ($stage->status !== 'vrij') {
            return back()->with('error', 'Deze stage is niet beschikbaar.');
        }

        // Koppel stage aan student
        $student->stage_id = $stage->id;
        $student->save();

        // Stage op slot
        $stage->status = 'gereserveerd';
        $stage->save();

        return back()->with('success', 'Stage succesvol gekozen, wacht op akkoord van docent.');
    }

    /**
     * Toon de keuze van een student via student_id
     */
    public function mijnKeuze(Student $student)
    {
        $mijnKeuze = $student->stage()->with(['teacher', 'company'])->first();

        return view('mijn-keuze', compact('mijnKeuze'));
    }
}
