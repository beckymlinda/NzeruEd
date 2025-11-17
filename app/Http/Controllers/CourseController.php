<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    // List all courses
    public function index()
    {
        $courses = Course::all(); // You can paginate if needed
        return view('courses.index', compact('courses'));
    }

    // Optional: show a single course with its assignments
    public function show(Course $course)
    {
        $assignments = $course->assignments;
        return view('courses.show', compact('course', 'assignments'));
    }
}
