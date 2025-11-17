<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// LMS routes: Lessons, Assignments, Submissions
Route::middleware(['auth', 'payment.approved'])->group(function () {

    // Lessons
    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/lesson/{lesson}', [LessonController::class, 'show'])->name('lessons.show');

    // Assignments
    Route::get('/assignments/{course}', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignment/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');

    // Submissions
    Route::post('/submission/{assignment}', [SubmissionController::class, 'store'])->name('submissions.store');
});

// Payments routes (auth only, no payment restriction for uploading proof)
Route::middleware(['auth'])->group(function () {
    Route::get('/payments/upload', [PaymentController::class, 'uploadForm'])->name('payment.upload');
    Route::post('/payments/upload', [PaymentController::class, 'upload'])->name('payment.upload.submit');
});

// Include Laravel Breeze or Jetstream auth routes
require __DIR__.'/auth.php';
