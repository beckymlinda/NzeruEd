<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'program_id', 'start_date', 'expected_end_date',
        'actual_end_date', 'progress_percentage', 'status'
    ];

    protected $dates = ['start_date', 'expected_end_date', 'actual_end_date'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function weeklyProgress()
    {
        return $this->hasMany(WeeklyProgress::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function studentAchievements()
    {
        return $this->hasMany(StudentAchievement::class);
    }
}
