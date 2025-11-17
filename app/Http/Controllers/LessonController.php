<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Progress;

class LessonController extends Controller
{
    // List all lessons
    public function index()
    {
        $lessons = Lesson::with('course')->get();
        return view('lessons.index', compact('lessons'));
    }

    // Show a single lesson
    public function show(Lesson $lesson)
    {
        $user = auth()->user();

        // If student and lesson is NOT free, update progress
        if ($user->isStudent() && !$lesson->is_free) {
            $progress = Progress::firstOrCreate(
                ['user_id' => $user->id, 'course_id' => $lesson->course_id]
            );

            $progress->completeLesson();
        }

        return view('lessons.show', compact('lesson'));
    }
}
