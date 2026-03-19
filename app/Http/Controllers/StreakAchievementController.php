<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\StudentAchievement;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StreakAchievementController extends Controller
{
    /**
     * Check and award streak-based achievements
     */
    public function checkStreakAchievements()
    {
        $user = Auth::user();
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$enrollment) {
            return response()->json(['achievements' => []]);
        }

        $attendance = Attendance::where('enrollment_id', $enrollment->id)->get();
        $currentStreak = $this->calculateCurrentStreak($attendance);
        $longestStreak = $this->calculateLongestStreak($attendance);
        
        $achievements = [];

        // Check for streak milestones
        $milestones = [3, 7, 14, 30, 60, 90];
        
        foreach ($milestones as $days) {
            if ($currentStreak >= $days) {
                $achievement = $this->awardAchievement($user->id, "streak_{$days}", [
                    'title' => "{$days}-Day Streak!",
                    'description' => "Maintained a {$days}-day attendance streak",
                    'icon' => '🔥',
                    'points' => $days * 10
                ]);
                if ($achievement) {
                    $achievements[] = $achievement;
                }
            }
            
            if ($longestStreak >= $days) {
                $achievement = $this->awardAchievement($user->id, "longest_streak_{$days}", [
                    'title' => "{$days}-Day Personal Best!",
                    'description' => "Achieved a {$days}-day longest streak",
                    'icon' => '⭐',
                    'points' => $days * 15
                ]);
                if ($achievement) {
                    $achievements[] = $achievement;
                }
            }
        }

        return response()->json([
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
            'new_achievements' => $achievements
        ]);
    }

    /**
     * Award achievement to student
     */
    private function awardAchievement($userId, $achievementKey, $achievementData)
    {
        // Check if already awarded
        $existing = StudentAchievement::where('user_id', $userId)
            ->where('achievement_key', $achievementKey)
            ->first();

        if ($existing) {
            return null; // Already awarded
        }

        // Create or get achievement
        $achievement = Achievement::firstOrCreate([
            'key' => $achievementKey,
            'title' => $achievementData['title'],
            'description' => $achievementData['description'],
            'icon' => $achievementData['icon'],
            'points' => $achievementData['points'],
            'type' => 'streak'
        ]);

        // Award to student
        return StudentAchievement::create([
            'user_id' => $userId,
            'achievement_id' => $achievement->id,
            'achievement_key' => $achievementKey,
            'earned_at' => now()
        ]);
    }

    /**
     * Calculate current streak
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
     * Calculate longest streak
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
}
