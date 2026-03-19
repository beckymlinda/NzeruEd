<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklyPose extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_target_id',
        'pose_name',
        'difficulty_level',
        'hold_time_seconds',
        'notes',
        'media_path', // added
    ];

    // Relationship to weekly target
    public function weeklyTarget()
    {
        return $this->belongsTo(WeeklyTarget::class);
    }

    // Relationship to assigned students
    public function students()
    {
        return $this->belongsToMany(User::class, 'weekly_pose_student', 'weekly_pose_id', 'user_id');
    }
}
