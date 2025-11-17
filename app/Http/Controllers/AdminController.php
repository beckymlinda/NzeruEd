<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;

class AdminController extends Controller
{
    public function index()
    {
        $coursesCount = Course::count();
        $assignmentsCount = Assignment::count();
        $submissionsCount = Submission::count();

        return view('admin.dashboard', compact('coursesCount', 'assignmentsCount', 'submissionsCount'));
    }
}
