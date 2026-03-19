<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\WeeklyPose;
use Illuminate\Support\Facades\Auth;

class StudentWeeklyPoseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrollment = Enrollment::where('user_id', $user->id)
                                ->where('status', 'active')
                                ->first();

        if (!$enrollment) {
            return view('student.weekly_poses', ['poses' => []]);
        }

        // Get poses specifically assigned to this student
        $assignedPoses = WeeklyPose::select('weekly_poses.*')
            ->join('weekly_pose_student', 'weekly_poses.id', '=', 'weekly_pose_student.weekly_pose_id')
            ->where('weekly_pose_student.user_id', $user->id)
            ->orderBy('weekly_poses.pose_name')
            ->with('weeklyTarget')
            ->get();

        // Get all poses for their program that are not specifically assigned to other students
        $generalPoses = WeeklyPose::select('weekly_poses.*')
            ->join('weekly_targets', 'weekly_poses.weekly_target_id', '=', 'weekly_targets.id')
            ->where('weekly_targets.program_id', $enrollment->program_id)
            ->whereNotIn('weekly_poses.id', function($query) {
                $query->select('weekly_pose_id')
                      ->from('weekly_pose_student')
                      ->whereRaw('weekly_pose_student.user_id != ?', [Auth::id()]);
            })
            ->orderBy('weekly_targets.week_number', 'asc')
            ->with('weeklyTarget')
            ->get();

        // Merge and remove duplicates
        $poses = $assignedPoses->merge($generalPoses)->unique('id');

        return view('student.weekly_poses', compact('poses'));
    }
}
