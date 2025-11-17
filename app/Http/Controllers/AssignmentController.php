<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Course;

class AssignmentController extends Controller
{
    public function index(Course $course)
    {
        $assignments = $course->assignments;
        return view('assignments.index', compact('course', 'assignments'));
    }

    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }
}
