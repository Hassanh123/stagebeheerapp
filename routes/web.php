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

// Root: toon de homepage
Route::get('/', function () {
    return view('home'); // Zorg dat resources/views/home.blade.php bestaat
})->name('home');

// Authenticated dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Resource index routes (Blade views) zonder 'resources' prefix
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/stages', [StageController::class, 'index'])->name('stages.index');
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');

require __DIR__.'/auth.php';
