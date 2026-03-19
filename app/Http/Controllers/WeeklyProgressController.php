<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\ProgressMedia;
use App\Models\WeeklyProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WeeklyProgressController extends Controller
{
    /**
     * Store weekly progress for a student.
     */
    
 
    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id'    => 'required|exists:enrollments,id',
            'week_number'      => 'required|integer|min:1|max:12',
            'instructor_notes' => 'nullable|string',
            'flexibility_score'=> 'nullable|numeric|min:0|max:10',
            'strength_score'   => 'nullable|numeric|min:0|max:10',
            'balance_score'    => 'nullable|numeric|min:0|max:10',
            'mindset_score'    => 'nullable|numeric|min:0|max:10',
            'overall_feedback' => 'nullable|string',
            'media'            => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240', // max 10MB
        ]);

        // Create weekly progress record
        $progress = WeeklyProgress::create($request->only([
            'enrollment_id',
            'week_number',
            'instructor_notes',
            'flexibility_score',
            'strength_score',
            'balance_score',
            'mindset_score',
            'overall_feedback',
        ]));

        // If media file is uploaded
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('progress-media', 'public');

            ProgressMedia::create([
                'weekly_progress_id' => $progress->id,
                'file_path'          => $path,
                'media_type'         => str_contains($file->getMimeType(), 'video') ? 'video' : 'photo',
                'is_best_of_week'    => true,
            ]);
        }

        return back()->with('success', 'Weekly progress recorded successfully.');
    }
    public function index()
{
    // Get all weekly progress with enrollment, student, and program info
    $weeklyProgresses = WeeklyProgress::with([
        'enrollment.user', 
        'enrollment.program'
    ])->orderBy('created_at', 'desc')->get();

    return view('admin.weekly_progress.index', compact('weeklyProgresses'));
}

public function studentIndex()
{
    // Get weekly progress for the authenticated student only
    $weeklyProgresses = WeeklyProgress::with(['progressMedia', 'enrollment.program'])
        ->whereHas('enrollment', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->orderBy('week_number', 'asc') // sort by week
        ->get();

    return view('student.weekly_progress', compact('weeklyProgresses'));
}
public function create()
{
    $enrollments = Enrollment::with(['user', 'program'])
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.weekly_progress.create', compact('enrollments'));
}

 
}
