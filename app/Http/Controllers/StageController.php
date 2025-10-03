<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Student;
use App\Models\Company;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StageController extends Controller
{
   public function index(Request $request)
{
    $query = Stage::with(['company', 'teacher', 'tags']);

    // Filter op tag (indien meegegeven in de URL)
    if ($request->filled('tag')) {
        $query->whereHas('tags', function ($q) use ($request) {
            $q->where('naam', $request->tag);
        });
    }

    $stages = $query->get();

    $student = Auth::check() && Auth::user()->role === 'student'
        ? Auth::user()->student
        : null;

    $mijnKeuze = null;

    if ($student && $student->stage_id) {
        $stage = Stage::with(['company', 'teacher', 'tags'])->find($student->stage_id);

        if ($stage && in_array($stage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
            $mijnKeuze = $stage;
        }
    }

    // Alle beschikbare tags voor de filter dropdown
    $tags = Tag::all();

    // Alle bedrijven (voor bijv. home weergave)
    $companies = Company::all();

    // 👉 Gebruik de home view
    return view('home', compact('stages', 'companies', 'mijnKeuze', 'tags'));
}

    /**
     * Laat een ingelogde student een stage kiezen
     */
    public function choose(Stage $stage)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'student') {
            return back()->with('error', 'Je bent geen student.');
        }

        $student = $user->student;

        if ($student->stage_id) {
            $gekozenStage = Stage::find($student->stage_id);
            if ($gekozenStage && in_array($gekozenStage->status, ['in_behandeling', 'goedgekeurd', 'afgekeurd'])) {
                return back()->with('error', 'Je hebt al een stage gekozen.');
            }
        }

        if ($stage->status !== 'vrij') {
            return back()->with('error', 'Deze stage is niet beschikbaar.');
        }

        // Stage reserveren
        $stage->status = 'in_behandeling';
        $stage->save();

        // Koppel stage aan student
        $student->stage_id = $stage->id;
        $student->save();

        return back()->with('success', 'Je keuze is opgeslagen en wordt beoordeeld door de beheerder.');
    }

    /**
     * Toon de keuze van een specifieke student
     */
    public function mijnKeuze(Student $student)
    {
        $mijnKeuze = $student->stage()->with(['teacher', 'company'])->first();

        return view('mijn-keuze', compact('mijnKeuze'));
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
