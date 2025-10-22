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

// ------------------------
// Authenticated routes (student / teacher / admin redirect via Filament)
// ------------------------
Route::middleware(['auth:web', 'verified'])->group(function () {

    // Dashboard
 Route::get('/dashboard', function () {
    $user = Auth::guard('web')->user();

    // Admins worden doorgestuurd naar Filament
    if ($user->role === 'admin') {
        return redirect('/admin');
    }

    // Haal het studentmodel op als het een student is
    $student = $user->role === 'student' ? $user->student : null;

    // Eén dashboard voor student en teacher
    return view('dashboard', [
        'user' => $user,
        'student' => $student,
    ]);

})->name('dashboard');


    // Profiel routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Stage kiezen (studenten)
    Route::post('/stages/{stage}/choose', [StageController::class, 'choose'])->name('stages.choose');

    // Mijn keuze bekijken
    Route::get('/mijn-keuze', [StageController::class, 'mijnKeuze'])->name('mijn-keuze');

    // Admin acties via web guard mogen alleen als role=admin
    Route::post('/stages/{stage}/approve', [StageController::class, 'adminApprove'])->middleware('role:admin')->name('stages.approve');
    Route::post('/stages/{stage}/reject', [StageController::class, 'adminReject'])->middleware('role:admin')->name('stages.reject');
});

// ------------------------
// Filament / Admin routes (eigen guard)
// ------------------------
Route::prefix('admin')->group(function () {
    // Filament regelt login en admin dashboard
});

require __DIR__.'/auth.php';
