<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Program;

class EnrollmentController extends Controller
{
    // Show form to create a new enrollment
    public function create()
    {
        $students = User::where('role', 'student')->get();
        $programs = Program::all();

        return view('admin.enrollments.create', compact('students', 'programs'));
    }

    // Store the new enrollment
  public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'program_id' => 'required|exists:programs,id',
        'start_date' => 'required|date',
        'status' => 'required|in:active,inactive',
    ]);

    $program = \App\Models\Program::findOrFail($request->program_id);

    $startDate = \Carbon\Carbon::parse($request->start_date);
    $expectedEndDate = $startDate->copy()->addWeeks($program->duration_weeks);

    Enrollment::create([
        'user_id' => $request->user_id,
        'program_id' => $request->program_id,
        'start_date' => $startDate,
        'expected_end_date' => $expectedEndDate,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Student enrolled successfully');
}

}
