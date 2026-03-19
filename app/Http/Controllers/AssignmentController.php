<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    // Admin view all assignments
    public function adminIndex()
    {
        $assignments = Assignment::with('submissions.student')
            ->orderBy('due_date', 'desc')
            ->get();

        return view('admin.assignments.index', compact('assignments'));
    }

    // Admin create assignment
 public function create()
{
    // Get all students
    $students = \App\Models\User::where('role', 'student')->get();

    return view('admin.assignments.create', compact('students'));
}

public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date'    => 'required|date',
        'media'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
        'students'    => 'required|array',
        'students.*'  => 'exists:users,id',
    ]);

    $data = $request->only(['title','description','due_date']);

    if ($request->hasFile('media')) {
        $data['media_path'] = $request->file('media')->store('assignments', 'public');
    }

    $assignment = Assignment::create($data);

    // Assign to selected students
    $assignment->assignedUsers()->sync($request->students);

    return redirect()->route('admin.assignments.index')->with('success', 'Assignment created and assigned successfully.');
}


    // Student view assignments
public function studentIndex()
{
    $user = auth()->user();

    // ✅ Mark assignments as seen
    $user->update([
        'assignments_last_seen_at' => now(),
    ]);

    $assignments = $user->assignments()
        ->with('submissions')
        ->get();

    return view('student.assignments.index', compact('assignments'));
}



    // Student upload submission
    public function submit(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file'  => 'required|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
            'notes' => 'nullable|string',
        ]);

        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id'       => Auth::id()
            ],
            [
                'file_path' => $request->file('file')->store('assignment-submissions', 'public'),
                'notes'     => $request->notes
            ]
        );

        return back()->with('success', 'Assignment submitted successfully.');
    }
    // Show edit form
public function edit(Assignment $assignment)
{
    $students = \App\Models\User::where('role','student')->get();
    $assignedIds = $assignment->assignedUsers()->pluck('user_id')->toArray();

    return view('admin.assignments.edit', compact('assignment','students','assignedIds'));
}

// Update assignment
public function update(Request $request, Assignment $assignment)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date'    => 'required|date',
        'media'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
        'students'    => 'required|array',
        'students.*'  => 'exists:users,id',
    ]);

    $data = $request->only(['title','description','due_date']);

    if ($request->hasFile('media')) {
        // Delete old media if exists
        if ($assignment->media_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($assignment->media_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($assignment->media_path);
        }

        $data['media_path'] = $request->file('media')->store('assignments','public');
    }

    $assignment->update($data);

    // Update assigned students
    $assignment->assignedUsers()->sync($request->students);

    return redirect()->route('admin.assignments.index')->with('success','Assignment updated successfully.');
}

// Delete assignment
public function destroy(Assignment $assignment)
{
    // Delete media if exists
    if ($assignment->media_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($assignment->media_path)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($assignment->media_path);
    }

    $assignment->delete();

    return redirect()->route('admin.assignments.index')->with('success','Assignment deleted successfully.');
}

}
