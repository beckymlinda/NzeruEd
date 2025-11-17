<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(Course $course)
    {
        $assignments = $course->assignments;
        return view('admin.assignments.index', compact('course', 'assignments'));
    }

    public function create(Course $course)
    {
        return view('admin.assignments.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240'
        ]);

        $path = $request->file('attachment') ? $request->file('attachment')->store('assignments') : null;

        $course->assignments()->create([
            'title' => $request->title,
            'instructions' => $request->instructions,
            'attachment' => $path,
        ]);

        return redirect()->route('courses.assignments.index', $course)->with('success', 'Assignment created.');
    }

    public function edit(Assignment $assignment)
    {
        return view('admin.assignments.edit', compact('assignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240'
        ]);

        if ($request->hasFile('attachment')) {
            if ($assignment->attachment) Storage::delete($assignment->attachment);
            $assignment->attachment = $request->file('attachment')->store('assignments');
        }

        $assignment->title = $request->title;
        $assignment->instructions = $request->instructions;
        $assignment->save();

        return redirect()->route('courses.assignments.index', $assignment->course)->with('success', 'Assignment updated.');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->attachment) Storage::delete($assignment->attachment);
        $assignment->delete();
        return back()->with('success', 'Assignment deleted.');
    }
}
