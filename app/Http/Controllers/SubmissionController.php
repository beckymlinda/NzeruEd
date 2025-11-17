<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Assignment;
use App\Models\Progress;

class SubmissionController extends Controller
{
    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $path = $request->file('file')->store('submissions');

        $submission = Submission::create([
            'assignment_id' => $assignment->id,
            'user_id' => auth()->id(),
            'file_path' => $path,
            'submitted_at' => now(),
        ]);

        // Update progress
        $progress = Progress::firstOrCreate([
            'user_id' => auth()->id(),
            'course_id' => $assignment->course_id,
        ]);

        $progress->submitAssignment();

        return redirect()->back()->with('success', 'Assignment submitted successfully.');
    }
}
