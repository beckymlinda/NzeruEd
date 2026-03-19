<?php

namespace App\Http\Controllers\Admin;

use App\Models\WeeklyPose;
use App\Models\WeeklyTarget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class WeeklyPoseController extends Controller
{
    // Show form
    public function create()
    {
        $weeklyTargets = WeeklyTarget::orderBy('week_number')->get();
        return view('admin.weekly_pose.create', compact('weeklyTargets'));
    }

    // Store new pose
    public function store(Request $request)
    {
        $request->validate([
            'weekly_target_id'  => 'required|exists:weekly_targets,id',
            'pose_name'         => 'required|string|max:255',
            'hold_time_seconds' => 'nullable|integer|min:1',
            'notes'             => 'nullable|string',
            'media'             => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'students'          => 'nullable|array',
            'students.*'        => 'exists:users,id',
        ]);

        $data = $request->only(['weekly_target_id','pose_name','hold_time_seconds','notes']);

        // Handle image upload
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('weekly-poses', 'public');
            $data['media_path'] = $path;
        }

        $weeklyPose = WeeklyPose::create($data);

        // Assign to specific students if selected
        if ($request->has('students') && !empty($request->students)) {
            $weeklyPose->students()->attach($request->students);
        }

        return redirect()->route('admin.weekly-poses.index')
                         ->with('success', 'Pose added successfully.');
    }

    // List all poses
    public function index()
    {
        $poses = WeeklyPose::with('weeklyTarget')
            ->orderBy('weekly_target_id')
            ->get();

        return view('admin.weekly_pose.index', compact('poses'));
    }
       public function edit(WeeklyPose $weeklyPose)
    {
        // Get all weekly targets for the select dropdown
        $weeklyTargets = WeeklyTarget::orderBy('week_number')->get();

        return view('admin.weekly_pose.edit', compact('weeklyPose', 'weeklyTargets'));
    }
    
     public function update(Request $request, WeeklyPose $weeklyPose)
    {
        // Validation (same as store)
        $request->validate([
            'weekly_target_id'  => 'required|exists:weekly_targets,id',
            'pose_name'         => 'required|string|max:255',
            'hold_time_seconds' => 'nullable|integer|min:1',
            'notes'             => 'nullable|string',
            'media'             => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'students'          => 'nullable|array',
            'students.*'        => 'exists:users,id',
        ]);

        $data = $request->only(['weekly_target_id','pose_name','hold_time_seconds','notes']);

        // Handle image upload
        if ($request->hasFile('media')) {
            // Delete old image if exists
            if ($weeklyPose->media_path && Storage::disk('public')->exists($weeklyPose->media_path)) {
                Storage::disk('public')->delete($weeklyPose->media_path);
            }

            $path = $request->file('media')->store('weekly-poses', 'public');
            $data['media_path'] = $path;
        }

        $weeklyPose->update($data);

        // Update student assignments
        if ($request->has('students') && !empty($request->students)) {
            // Sync with selected students
            $weeklyPose->students()->sync($request->students);
        } else {
            // Remove all specific assignments (makes it available to all students)
            $weeklyPose->students()->detach();
        }

        return redirect()->route('admin.weekly-poses.index')
                         ->with('success', 'Pose updated successfully.');
    }
public function destroy($id)
{
    $pose = WeeklyPose::findOrFail($id);

    // If pose has media or images, delete them here if needed

    $pose->delete();

    return redirect()
        ->back()
        ->with('success', 'Weekly pose deleted successfully.');
}
}
