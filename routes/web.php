<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WeeklyProgressController;
use App\Http\Controllers\Admin\WeeklyPoseController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\Admin\WeeklyTargetController;
use App\Http\Controllers\StudentAchievementController;
use App\Http\Controllers\Student\StudentProgramController;
use App\Http\Controllers\Student\StudentWeeklyPoseController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze / Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php'; // login, register, logout routes

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Requires login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    */
  Route::middleware('role:student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});



    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/student/{userId}', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

        // Weekly Progress
        Route::post('/weekly-progress', [WeeklyProgressController::class, 'store'])->name('weekly-progress.store');

        // Student Achievements
        Route::get('/achievements', [StudentAchievementController::class, 'index'])->name('achievements.index');
        Route::post('/achievements', [StudentAchievementController::class, 'store'])->name('achievements.store');
    });// Enrollment Routes
Route::get('/enrollments/create', [EnrollmentController::class, 'create'])
    ->name('admin.enrollments.create');

Route::post('/enrollments', [EnrollmentController::class, 'store'])
    ->name('admin.enrollments.store');
  



});
// Admin routes
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Show form
    Route::get('/attendance/create', [AttendanceController::class, 'create'])
        ->name('attendance.create');

    // Submit form
    Route::post('/attendance', [AttendanceController::class, 'store'])
        ->name('attendance.store');
});


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/weekly-targets', [WeeklyTargetController::class, 'index'])
            ->name('weekly-targets.index');

        Route::get('/weekly-targets/create', [WeeklyTargetController::class, 'create'])
            ->name('weekly-targets.create');

        Route::post('/weekly-targets', [WeeklyTargetController::class, 'store'])
            ->name('weekly-targets.store');
    });


Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/weekly-poses/create',
            [App\Http\Controllers\Admin\WeeklyPoseController::class, 'create']
        )->name('weekly-poses.create');

        Route::post('/weekly-poses',
            [App\Http\Controllers\Admin\WeeklyPoseController::class, 'store']
        )->name('weekly-poses.store');
});


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/weekly-progress', function () {
            return view('admin.weekly_progress.index');
        })->name('weekly-progress.index');

        Route::get('/weekly-progress/create', function () {
            return view('admin.weekly_progress.create');
        })->name('weekly-progress.create');

        Route::post('/weekly-progress', [WeeklyProgressController::class, 'store'])
            ->name('weekly-progress.store');
    });

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Existing routes...
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('/weekly-progress', [WeeklyProgressController::class, 'store'])->name('weekly-progress.store');
    Route::post('/achievements', [StudentAchievementController::class, 'store'])->name('achievements.store');

    // ✅ Payment routes
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');



    
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('weekly-progress', WeeklyProgressController::class)
        ->names([
            'index'   => 'weekly-progress.index',
            'create'  => 'weekly-progress.create',
            'store'   => 'weekly-progress.store',
            'show'    => 'weekly-progress.show',
            'edit'    => 'weekly-progress.edit',
            'update'  => 'weekly-progress.update',
            'destroy' => 'weekly-progress.destroy',
        ]);

    // ✅ Payment reminder routes
    Route::get('/payment-reminders', function() {
        return app('App\Http\Controllers\PaymentReminderController')->index();
    })->name('payment-reminders.index');
    
    Route::post('/payment-reminders', function(\Illuminate\Http\Request $request) {
        return app('App\Http\Controllers\PaymentReminderController')->create($request);
    })->name('payment-reminders.create');
    
    Route::post('/payment-reminders/bulk', function(\Illuminate\Http\Request $request) {
        return app('App\Http\Controllers\PaymentReminderController')->sendBulkReminders($request);
    })->name('payment-reminders.bulk');

});
// routes/web.php 

Route::middleware(['auth'])->group(function() {

    // STUDENT ROUTES
    Route::prefix('student')->group(function() {
        Route::get('/weekly-poses', [StudentWeeklyPoseController::class, 'index'])
            ->name('student.weekly-poses');

        Route::get('/programs', [StudentProgramController::class, 'index'])
            ->name('student.programs.index');

        Route::get('/programs/{program}', [StudentProgramController::class, 'show'])
            ->name('student.programs.show');

        Route::get('/weekly-progress', [App\Http\Controllers\StudentDashboardController::class, 'weeklyProgress'])
            ->name('student.weekly-progress');

        Route::get('/weekly-progress/{id}', [App\Http\Controllers\StudentDashboardController::class, 'showWeeklyProgress'])
            ->name('student.weekly-progress.show');

        Route::get('/weekly-progress/{id}/download-pdf', [App\Http\Controllers\StudentDashboardController::class, 'downloadWeeklyProgressPDF'])
            ->name('student.weekly-progress.download-pdf');

        Route::get('/attendance', [App\Http\Controllers\StudentDashboardController::class, 'attendance'])
            ->name('student.attendance');

        Route::get('/payment-history', [App\Http\Controllers\StudentDashboardController::class, 'paymentHistory'])
            ->name('student.payment-history');

        Route::get('/profile', [App\Http\Controllers\StudentDashboardController::class, 'profile'])
            ->name('student.profile');

        Route::post('/profile/update', [App\Http\Controllers\StudentDashboardController::class, 'updateProfile'])
            ->name('student.profile.update');

        Route::post('/profile/change-password', [App\Http\Controllers\StudentDashboardController::class, 'changePassword'])
            ->name('student.profile.change-password');

        Route::get('/streak-details', [App\Http\Controllers\StreakController::class, 'getStreakDetails'])
            ->name('student.streak-details');

        Route::post('/streak-achievements', [App\Http\Controllers\StreakAchievementController::class, 'checkStreakAchievements'])
            ->name('student.streak-achievements');
    });

    // ADMIN ROUTES
    Route::prefix('admin')->name('admin.')->group(function () {

        // Weekly Poses
        Route::resource('weekly-poses', WeeklyPoseController::class);

        // Weekly Targets
        Route::resource('weekly-targets', WeeklyTargetController::class);
    });
});
Route::get('/weekly-progress', [WeeklyProgressController::class, 'index'])->name('weekly-progress.index');
// Student Weekly Progress
Route::middleware(['auth'])->group(function () {
    Route::get('/my-weekly-progress', [WeeklyProgressController::class, 'studentIndex'])
        ->name('student.weekly-progress');
});


// Admin // Admin assignments
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/assignments', [AssignmentController::class, 'adminIndex'])->name('assignments.index');
    Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments/store', [AssignmentController::class, 'store'])->name('assignments.store');
});


// Student assignments
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/assignments', [AssignmentController::class, 'studentIndex'])->name('student.assignments.index');
    Route::post('/assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('student.assignments.submit');
});
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/assignments', [AssignmentController::class,'adminIndex'])->name('assignments.index');
    Route::get('/assignments/create', [AssignmentController::class,'create'])->name('assignments.create');
    Route::post('/assignments/store', [AssignmentController::class,'store'])->name('assignments.store');

    Route::get('/assignments/{assignment}/edit', [AssignmentController::class,'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [AssignmentController::class,'update'])->name('assignments.update');
    Route::delete('/assignments/{assignment}', [AssignmentController::class,'destroy'])->name('assignments.destroy');
});

// Notification routes
Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');

