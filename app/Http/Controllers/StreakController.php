<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreakController extends Controller
{
    /**
     * Get detailed streak information for student
     */
    public function getStreakDetails()
    {
        $user = Auth::user();
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return response()->json([
                'current_streak' => 0,
                'longest_streak' => 0,
                'total_days' => 0,
                'this_week' => 0,
                'this_month' => 0,
                'recent_activity' => []
            ]);
        }

        $attendance = Attendance::where('enrollment_id', $enrollment->id)->get();
        
        return response()->json([
            'current_streak' => $this->calculateCurrentStreak($attendance),
            'longest_streak' => $this->calculateLongestStreak($attendance),
            'total_days' => $attendance->where('status', 'present')->count(),
            'this_week' => $this->getThisWeekAttendance($attendance),
            'this_month' => $this->getThisMonthAttendance($attendance),
            'recent_activity' => $this->getRecentActivity($attendance)
        ]);
    }

    /**
     * Calculate current streak (consecutive days)
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

        $currentDate = now()->startOfDay();
        
        foreach ($attendanceDates->reverse() as $date) {
            $attendanceDate = \Carbon\Carbon::parse($date)->startOfDay();
            
            if ($attendanceDate->diffInDays($currentDate) === $streak) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * Calculate longest streak in history
     */
    private function calculateLongestStreak($attendance)
    {
        $presentDates = $attendance
            ->where('status', 'present')
            ->pluck('session_date')
            ->sort()
            ->values();

        if ($presentDates->isEmpty()) {
            return 0;
        }

        $longestStreak = 0;
        $currentStreak = 0;
        $previousDate = null;

        foreach ($presentDates as $date) {
            $currentDate = \Carbon\Carbon::parse($date)->startOfDay();
            
            if ($previousDate && $currentDate->diffInDays($previousDate) === 1) {
                $currentStreak++;
            } else {
                $currentStreak = 1;
            }
            
            $longestStreak = max($longestStreak, $currentStreak);
            $previousDate = $currentDate;
        }

        return $longestStreak;
    }

    /**
     * Get this week's attendance count
     */
    private function getThisWeekAttendance($attendance)
    {
        return $attendance
            ->where('status', 'present')
            ->where('session_date', '>=', now()->startOfWeek())
            ->count();
    }

    /**
     * Get this month's attendance count
     */
    private function getThisMonthAttendance($attendance)
    {
        return $attendance
            ->where('status', 'present')
            ->where('session_date', '>=', now()->startOfMonth())
            ->count();
    }

    /**
     * Get recent activity (last 10 days)
     */
    private function getRecentActivity($attendance)
    {
        $recentDays = [];
        
        for ($i = 0; $i < 10; $i++) {
            $date = now()->subDays($i);
            $dayAttendance = $attendance
                ->where('session_date', $date->format('Y-m-d'))
                ->first();
                
            $recentDays[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $date->format('D'),
                'status' => $dayAttendance ? $dayAttendance->status : 'no_record',
                'present' => $dayAttendance && $dayAttendance->status === 'present'
            ];
        }
        
        return array_reverse($recentDays);
    }
}
