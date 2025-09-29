<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage met alle stages en bedrijven
Route::get('/', [StageController::class, 'index'])->name('home');

// Dashboard voor normale gebruikers (authenticatie vereist)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profiel routes (authenticatie vereist)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource routes (index only)
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/stages', [StageController::class, 'index'])->name('stages.index');
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');

// Stage kiezen (zonder login: student_id via POST)
Route::post('/stages/{stage}/choose', [StageController::class, 'choose'])->name('stages.choose');

// "Mijn keuze" bekijken via student_id (optioneel zonder login)
Route::get('/mijn-keuze/{student}', [StageController::class, 'mijnKeuze'])->name('mijn-keuze');

// Laravel auth routes
require __DIR__.'/auth.php';
