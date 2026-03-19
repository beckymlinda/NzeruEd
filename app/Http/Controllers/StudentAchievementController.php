<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentAchievement;
use App\Models\Achievement;

class StudentAchievementController extends Controller
{
    /**
     * Display a list of achievements.
     */
    public function index()
    {
        $achievements = Achievement::orderBy('title')->get();
        $studentAchievements = StudentAchievement::with(['enrollment.user', 'achievement'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.achievements.index', compact('achievements', 'studentAchievements'));
    }

    /**
     * Store a student achievement.
     */
    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id'   => 'required|exists:enrollments,id',
            'achievement_id'  => 'required|exists:achievements,id',
            'awarded_week'    => 'required|integer|min:1|max:12',
            'notes'           => 'nullable|string|max:255',
        ]);

        StudentAchievement::create($request->only([
            'enrollment_id',
            'achievement_id',
            'awarded_week',
            'notes',
        ]));

        return back()->with('success', 'Achievement awarded successfully.');
    }
}
