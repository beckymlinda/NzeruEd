<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\WeeklyProgress;
use App\Models\Attendance;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1️⃣ Active enrollment
        $enrollment = Enrollment::with([
                'program.weeklyTargets.weeklyPoses',
                'weeklyProgress.progressMedia',
                'attendance',
                'payments'
            ])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        // No enrollment yet
        if (!$enrollment) {
            return view('student.no-enrollment');
        }

        // 2️⃣ Current week
        $startDate   = $enrollment->start_date;
        $currentWeek = max(now()->diffInWeeks($startDate) + 1, 1);
        $currentWeek = min($currentWeek, 12);

        // 3️⃣ Progress %
        $progressPercentage = intval(($currentWeek / 12) * 100);

        // 4️⃣ Weekly target
        $weeklyTarget = $enrollment->program
            ->weeklyTargets
            ->where('week_number', $currentWeek)
            ->first();

        // 5️⃣ Weekly pose
        $weeklyPose = $weeklyTarget
            ? $weeklyTarget->weeklyPoses->first()
            : null;

        // 6️⃣ Weekly progress
        $weeklyProgress = $enrollment->weeklyProgress
            ->where('week_number', $currentWeek)
            ->first();

        // 7️⃣ Best media
        $bestMedia = $weeklyProgress
            ? $weeklyProgress->progressMedia
                ->where('is_best_of_week', true)
                ->first()
            : null;

        // 8️⃣ Attendance stats
        $attendanceStats = [
            'present' => $enrollment->attendance
                ->where('status', 'present')
                ->count(),
            'missed'  => $enrollment->attendance
                ->where('status', 'missed')
                ->count(),
            'total'   => $enrollment->attendance->count(),
        ];

        // 8.1️⃣ Recent attendance
        $recentAttendance = Attendance::where('enrollment_id', $enrollment->id)
            ->orderBy('session_date', 'desc')
            ->take(10)
            ->get();

        // 8.2️⃣ Current streak (consecutive present days)
        $currentStreak = $this->calculateCurrentStreak(
            Attendance::where('enrollment_id', $enrollment->id)->get()
        );

        // 9️⃣ Payment summary
        // Calculate payment summary using fixed monthly rate
        $monthlyRate = 120000; // Fixed MWK 120,000 per month
        $programDuration = $enrollment->program->duration_weeks; // Duration in weeks
        $monthsCompleted = min($programDuration / 4, \Carbon\Carbon::now()->diffInWeeks($enrollment->start_date) / 4); // Convert weeks to months
        $expectedAmount = $monthlyRate * ceil($monthsCompleted);
        
        $paid = Payment::where('enrollment_id', $enrollment->id)->sum('amount_paid');
        
        // Get actual expected amount from payment records if available
        $actualExpected = Payment::where('enrollment_id', $enrollment->id)
            ->whereNotNull('expected_amount')
            ->sum('expected_amount') ?: $expectedAmount;

        $paymentSummary = [
            'expected' => $actualExpected,
            'paid'    => $paid,
            'balance' => max($actualExpected - $paid, 0),
            'status'  => $paid >= $actualExpected ? 'Paid' : ($paid > 0 ? 'Partial' : 'Pending'),
        ];

        // 9.1️⃣ Recent payments
        $recentPayments = Payment::where('enrollment_id', $enrollment->id)
            ->orderBy('payment_date', 'desc')
            ->take(5)
            ->get();

        // 9.2️⃣ Achievement count (placeholder for now)
        $achievementCount = $enrollment->weeklyProgress
            ->where('overall_feedback', '!=', null)
            ->count();

        // 🔟 Encouragement
        $encouragementMessage = match (true) {
            $progressPercentage >= 75 => 'You are doing amazing — the finish line is close 🌟',
            $progressPercentage >= 40 => 'Consistency is paying off — keep showing up 💪',
            default                   => 'Every session matters — stay committed 🌱',
        };

        return view('student.dashboard', compact(
            'enrollment',
            'currentWeek',
            'progressPercentage',
            'weeklyTarget',
            'weeklyPose',
            'bestMedia',
            'attendanceStats',
            'paymentSummary',
            'encouragementMessage',
            'recentAttendance',
            'recentPayments',
            'currentStreak',
            'achievementCount'
        ));
    }
    public function weeklyProgress()
{
    $user = Auth::user();

    // Get the student's enrollment
    $enrollment = Enrollment::with(['program'])
        ->where('user_id', $user->id)
        ->where('status', 'active')
        ->first();

    if (!$enrollment) {
        return redirect()->back()->with('error', 'You have no active enrollment.');
    }

    // Get all weekly progress for this enrollment
    $weeklyProgresses = WeeklyProgress::with('progressMedia')
        ->where('enrollment_id', $enrollment->id)
        ->orderBy('week_number', 'asc')
        ->get();

    return view('student.weekly_progress', compact('enrollment', 'weeklyProgresses'));
    }

    /**
     * Show detailed weekly progress
     */
    public function showWeeklyProgress($id)
    {
        $user = Auth::user();

        // Get the specific weekly progress with all relationships
        $weeklyProgress = WeeklyProgress::with([
            'progressMedia',
            'enrollment.program'
        ])
        ->where('id', $id)
        ->whereHas('enrollment', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->firstOrFail();

        return view('student.weekly-progress-show', compact('weeklyProgress'));
    }

    /**
     * Download weekly progress PDF
     */
    public function downloadWeeklyProgressPDF($id)
    {
        $user = Auth::user();

        // Get the specific weekly progress with all relationships
        $weeklyProgress = WeeklyProgress::with([
            'progressMedia',
            'enrollment.program'
        ])
        ->where('id', $id)
        ->whereHas('enrollment', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->firstOrFail();

        // Generate PDF with simplified settings
        $pdf = PDF::loadView('student.weekly-progress-pdf', compact('weeklyProgress'))
            ->setPaper('a4', 'portrait');

        // Download filename
        $filename = 'Weekly-Progress-Week-' . $weeklyProgress->week_number . '-' . str_replace(' ', '-', auth()->user()->name) . '-' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Display student attendance overview
     */
    public function attendance()
    {
        $user = Auth::user();
        
        // Get student's active enrollment
        $enrollment = Enrollment::with(['attendance', 'program'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return view('student.attendance', compact('enrollment'));
        }

        // Get attendance records organized by week
        $attendanceRecords = $enrollment->attendance()
            ->orderBy('session_date', 'desc')
            ->get()
            ->groupBy('week_number');

        // Calculate statistics
        $totalSessions = $enrollment->attendance->count();
        $presentSessions = $enrollment->attendance->where('status', 'present')->count();
        $missedSessions = $enrollment->attendance->where('status', 'missed')->count();
        $attendanceRate = $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 1) : 0;

        // Calculate current streak
        $currentStreak = $this->calculateCurrentStreak($enrollment->attendance);

        // Get recent attendance (last 10 sessions)
        $recentAttendance = $enrollment->attendance()
            ->orderBy('session_date', 'desc')
            ->take(10)
            ->get();

        // Organize weekly data for charts
        $weeklyStats = [];
        for ($week = 1; $week <= 12; $week++) {
            $weekAttendance = $enrollment->attendance->where('week_number', $week);
            $weeklyStats[] = [
                'week' => $week,
                'present' => $weekAttendance->where('status', 'present')->count(),
                'missed' => $weekAttendance->where('status', 'missed')->count(),
                'total' => $weekAttendance->count()
            ];
        }

        return view('student.attendance', compact(
            'enrollment',
            'attendanceRecords',
            'totalSessions',
            'presentSessions',
            'missedSessions',
            'attendanceRate',
            'currentStreak',
            'recentAttendance',
            'weeklyStats'
        ));
    }

    /**
     * Display student payment history
     */
    public function paymentHistory()
    {
        $user = Auth::user();
        
        // Get student's active enrollment
        $enrollment = Enrollment::with(['program', 'payments'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return view('student.payment-history', compact('enrollment'));
        }

        // Get payment records
        $payments = $enrollment->payments()
            ->orderBy('payment_date', 'desc')
            ->get();

        // Calculate payment statistics
        $totalPaid = $payments->where('status', 'approved')->sum('amount_paid');
        $pendingPayments = $payments->where('status', 'pending')->sum('amount_paid');
        $rejectedPayments = $payments->where('status', 'rejected')->sum('amount_paid');
        
        // Calculate expected amount based on fixed monthly rate
        $monthlyRate = 120000; // Fixed MWK 120,000 per month
        $programDuration = $enrollment->program->duration_weeks; // Duration in weeks
        $monthsCompleted = min($programDuration / 4, \Carbon\Carbon::now()->diffInWeeks($enrollment->start_date) / 4); // Convert weeks to months
        $expectedAmount = $monthlyRate * ceil($monthsCompleted);
        
        // Get actual expected amount from payment records if available
        $actualExpected = Payment::where('enrollment_id', $enrollment->id)
            ->whereNotNull('expected_amount')
            ->sum('expected_amount') ?: $expectedAmount;
        
        $balance = $actualExpected - $totalPaid;
        $paymentStatus = $balance <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid');

        // Monthly payment breakdown
        $monthlyPayments = $payments->groupBy(function($payment) {
            return \Carbon\Carbon::parse($payment->payment_date)->format('Y-m');
        })->map(function($monthPayments) {
            return [
                'total' => $monthPayments->where('status', 'approved')->sum('amount_paid'),
                'count' => $monthPayments->where('status', 'approved')->count(),
                'month' => \Carbon\Carbon::parse($monthPayments->first()->payment_date)->format('F Y')
            ];
        });

        // Recent payments (last 10)
        $recentPayments = $payments->take(10);

        return view('student.payment-history', compact(
            'enrollment',
            'payments',
            'totalPaid',
            'pendingPayments',
            'rejectedPayments',
            'balance',
            'paymentStatus',
            'monthlyPayments',
            'recentPayments'
        ))->with('expectedAmount', $actualExpected);
    }

    /**
     * Display student profile
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Get student's active enrollment
        $enrollment = null;
        try {
            $enrollment = Enrollment::with(['program', 'attendance', 'payments'])
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->first();
        } catch (\Exception $e) {
            // Handle case where relationships don't exist
            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();
        }

        return view('student.profile', compact('user', 'enrollment'));
    }

    /**
     * Update student profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            
            // Debug: Log file info
            \Log::info('Profile photo upload attempt', [
                'original_name' => $photo->getClientOriginalName(),
                'size' => $photo->getSize(),
                'mime_type' => $photo->getMimeType(),
                'error' => $photo->getError()
            ]);
            
            $filename = time() . '_' . $photo->getClientOriginalName();
            
            // Debug: Log storage path
            $storagePath = storage_path('app/public/profile_photos/' . $filename);
            \Log::info('Storage path: ' . $storagePath);
            
            try {
                $photo->storeAs('profile_photos', $filename, 'public');
                \Log::info('Photo stored successfully: ' . $filename);
                $user->profile_photo = $filename;
            } catch (\Exception $e) {
                \Log::error('Photo storage failed: ' . $e->getMessage());
                return back()->with('error', 'Failed to upload photo: ' . $e->getMessage());
            }
        } else {
            \Log::info('No profile photo file found in request');
        }

        $user->save();

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Change student password
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }

    /**
     * Calculate current attendance streak (consecutive present days)
     */
    private function calculateCurrentStreak($attendance)
    {
        if ($attendance->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $attendanceDates = $attendance
            ->where('status', 'present')
            ->pluck('session_date')
            ->sort()
            ->values();

        if ($attendanceDates->isEmpty()) {
            return 0;
        }

        // Start from the most recent present day and count backwards
        $currentDate = now()->startOfDay();
        
        foreach ($attendanceDates->reverse() as $date) {
            $attendanceDate = \Carbon\Carbon::parse($date)->startOfDay();
            
            // If this attendance is from today or yesterday, continue counting
            if ($attendanceDate->diffInDays($currentDate) === $streak) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }

}
