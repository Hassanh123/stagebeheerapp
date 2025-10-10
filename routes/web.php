<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Openbare pagina's
Route::get('/', [StageController::class, 'index'])->name('home');

Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/stages', [StageController::class, 'index'])->name('stages.index');
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user?->role === 'admin') {
            return view('dashboard-admin');
        }
        // Studenten redirecten naar home
        return redirect()->route('home');
    })->name('dashboard');

    // Profiel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Stage kiezen (studenten)
    Route::post('/stages/{stage}/choose', [StageController::class, 'choose'])->name('stages.choose');

    // Mijn keuze bekijken
    Route::get('/mijn-keuze', [StageController::class, 'mijnKeuze'])->name('mijn-keuze');

    // Admin: stage goedkeuren of afkeuren
    Route::post('/stages/{stage}/approve', [StageController::class, 'adminApprove'])->name('stages.approve');
    Route::post('/stages/{stage}/reject', [StageController::class, 'adminReject'])->name('stages.reject');
});

require __DIR__.'/auth.php';
