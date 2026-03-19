<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Program;

class StudentProgramController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get student's current enrollment
        $enrollment = Enrollment::where('user_id', $user->id)
                                ->where('status', 'active')
                                ->first();

        $enrolledProgramId = $enrollment ? $enrollment->program_id : null;

        // Get all programs
        $programs = Program::orderBy('id', 'asc')->get();

        return view('student.programs', compact('programs', 'enrolledProgramId'));
    }
    public function show($programId)
{
    $program = \App\Models\Program::with(['weeklyTargets.weeklyPoses'])->findOrFail($programId);

    $user = auth()->user();
    $enrollment = \App\Models\Enrollment::where('user_id', $user->id)
                                        ->where('status', 'active')
                                        ->first();

    // Prevent access if student is not enrolled in this program
    if (!$enrollment || $enrollment->program_id != $program->id) {
        abort(403, 'You are not enrolled in this program.');
    }

    return view('student.program.show', compact('program'));
}

}
