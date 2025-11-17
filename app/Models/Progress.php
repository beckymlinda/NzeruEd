<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'lessons_completed', 'assignments_submitted', 'average_score'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function completeLesson()
    {
        $this->increment('lessons_completed');
    }

    public function submitAssignment()
    {
        $this->increment('assignments_submitted');
    }

    public function updateAverageScore($newScore)
    {
        $this->average_score = $newScore;
        $this->save();
    }
}
