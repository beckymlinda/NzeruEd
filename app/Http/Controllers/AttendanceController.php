<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display attendance overview with detailed statistics.
     */
    public function index()
    {
        // Get all active enrollments with attendance summary
        $enrollments = Enrollment::with(['user', 'attendance', 'payments'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        $attendanceData = [];
        
        foreach ($enrollments as $enrollment) {
            $totalSessions = $enrollment->attendance->count();
            $presentSessions = $enrollment->attendance->where('status', 'present')->count();
            $attendanceRate = $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 1) : 0;
            
            $attendanceData[] = [
                'student' => $enrollment->user,
                'enrollment' => $enrollment,
                'total_sessions' => $totalSessions,
                'present_sessions' => $presentSessions,
                'attendance_rate' => $attendanceRate,
                'last_attendance' => $enrollment->attendance->sortByDesc('session_date')->first(),
                'payment_status' => $this->getPaymentStatus($enrollment)
            ];
        }

        return view('admin.attendance.index', compact('attendanceData'));
    }

    /**
     * Show detailed attendance information for a specific student.
     */
    public function show($userId)
    {
        $enrollment = Enrollment::with(['user', 'attendance', 'payments'])
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->firstOrFail();

        // Organize attendance by weeks
        $weeklyData = [];
        $attendances = $enrollment->attendance->sortBy('session_date');
        
        foreach ($attendances as $attendance) {
            $weekNumber = $attendance->week_number;
            
            if (!isset($weeklyData[$weekNumber])) {
                $weeklyData[$weekNumber] = [
                    'week' => $weekNumber,
                    'sessions' => [],
                    'total_sessions' => 0,
                    'present_sessions' => 0,
                    'paid_sessions' => 0
                ];
            }
            
            $weeklyData[$weekNumber]['sessions'][] = $attendance;
            $weeklyData[$weekNumber]['total_sessions']++;
            
            if ($attendance->status === 'present') {
                $weeklyData[$weekNumber]['present_sessions']++;
            }
            
            if ($attendance->payment_status === 'paid') {
                $weeklyData[$weekNumber]['paid_sessions']++;
            }
        }

        // Calculate progress
        $totalSessions = $enrollment->attendance->count();
        $presentSessions = $enrollment->attendance->where('status', 'present')->count();
        $attendanceRate = $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 1) : 0;
        
        // Payment details
        $paymentStatus = $this->getPaymentStatus($enrollment);
        $totalPaid = $enrollment->payments->where('status', 'approved')->sum('amount');
        $expectedAmount = $this->calculateExpectedAmount($enrollment);
        $balance = $expectedAmount - $totalPaid;

        return view('admin.attendance.show', compact(
            'enrollment', 
            'weeklyData', 
            'attendanceRate', 
            'paymentStatus', 
            'totalPaid', 
            'expectedAmount', 
            'balance'
        ));
    }

    /**
     * Calculate weekly attendance statistics for a student
     */
    private function calculateWeeklyStats($enrollment)
    {
        $weeklyStats = [];
        $attendance = $enrollment->attendance->sortBy('session_date');
        
        foreach ($attendance as $record) {
            $weekNumber = $this->getWeekNumber($record->session_date, $enrollment->start_date);
            
            if (!isset($weeklyStats[$weekNumber])) {
                $weeklyStats[$weekNumber] = [
                    'week' => $weekNumber,
                    'sessions' => 0,
                    'present' => 0,
                    'missed' => 0,
                    'performance_scores' => [],
                    'dates' => []
                ];
            }
            
            $weeklyStats[$weekNumber]['sessions']++;
            $weeklyStats[$weekNumber]['dates'][] = $record->session_date->format('M d');
            
            if ($record->status === 'present') {
                $weeklyStats[$weekNumber]['present']++;
                // Add performance score if available
                if ($record->performance_score) {
                    $weeklyStats[$weekNumber]['performance_scores'][] = $record->performance_score;
                }
            } else {
                $weeklyStats[$weekNumber]['missed']++;
            }
        }

        // Calculate average performance per week
        foreach ($weeklyStats as $week => &$stats) {
            if (!empty($stats['performance_scores'])) {
                $stats['avg_performance'] = round(array_sum($stats['performance_scores']) / count($stats['performance_scores']), 1);
            } else {
                $stats['avg_performance'] = null;
            }
        }

        return $weeklyStats;
    }

    /**
     * Get week number from date
     */
    private function getWeekNumber($sessionDate, $startDate)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $session = \Carbon\Carbon::parse($sessionDate);
        return $session->diffInWeeks($start) + 1;
    }

    /**
     * Get payment status for enrollment
     */
    private function getPaymentStatus($enrollment)
    {
        $totalPaid = $enrollment->payments->where('status', 'approved')->sum('amount');
        $expectedAmount = $this->calculateExpectedAmount($enrollment);
        
        return [
            'total_paid' => $totalPaid,
            'expected' => $expectedAmount,
            'status' => $totalPaid >= $expectedAmount ? 'paid' : 'partial',
            'percentage' => $expectedAmount > 0 ? round(($totalPaid / $expectedAmount) * 100, 1) : 0
        ];
    }

    /**
     * Calculate expected payment amount based on enrollment duration
     */
    private function calculateExpectedAmount($enrollment)
    {
        // Assuming MWK 5000 per session, 3 sessions per week
        $sessionsPerWeek = 3;
        $ratePerSession = 5000;
        
        $weeksCompleted = min(4, \Carbon\Carbon::now()->diffInWeeks($enrollment->start_date) + 1);
        $expectedSessions = $weeksCompleted * $sessionsPerWeek;
        
        return $expectedSessions * $ratePerSession;
    }
    /**
     * Store attendance for a student session.
     */
    public function create()
{
    $enrollments = \App\Models\Enrollment::with('user')
        ->where('status', 'active')
        ->get();

    return view('admin.attendance.create', compact('enrollments'));
}

    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'session_date'  => 'required|date',
            'week_number'   => 'required|integer|min:1|max:4',
            'session_number'=> 'required|integer|min:1|max:3',
            'status'        => 'required|in:present,missed',
            'payment_status'=> 'required|in:unpaid,paid,partial',
            'reason'        => 'nullable|string|max:255',
        ]);

        Attendance::create([
            'enrollment_id' => $request->enrollment_id,
            'session_date'  => $request->session_date,
            'week_number'   => $request->week_number,
            'session_number'=> $request->session_number,
            'status'        => $request->status,
            'payment_status'=> $request->payment_status,
            'reason'        => $request->reason,
            'recorded_by'   => Auth::id(),
        ]);

        return back()->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Show the form for editing attendance.
     */
    public function edit($id)
    {
        $attendance = Attendance::with('enrollment.user')->findOrFail($id);
        $enrollments = Enrollment::with('user')->where('status', 'active')->get();
        
        return view('admin.attendance.edit', compact('attendance', 'enrollments'));
    }

    /**
     * Update the attendance record.
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'session_date'  => 'required|date',
            'week_number'   => 'required|integer|min:1|max:4',
            'session_number'=> 'required|integer|min:1|max:3',
            'status'        => 'required|in:present,missed',
            'payment_status'=> 'required|in:unpaid,paid,partial',
            'reason'        => 'nullable|string|max:255',
        ]);

        $attendance->update([
            'enrollment_id' => $request->enrollment_id,
            'session_date'  => $request->session_date,
            'week_number'   => $request->week_number,
            'session_number'=> $request->session_number,
            'status'        => $request->status,
            'payment_status'=> $request->payment_status,
            'reason'        => $request->reason,
        ]);

        return redirect()->route('admin.attendance.index')
                         ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the attendance record.
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('admin.attendance.index')
                         ->with('success', 'Attendance deleted successfully.');
    }
}
