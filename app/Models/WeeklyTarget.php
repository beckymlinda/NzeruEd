<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklyTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id', 'week_number', 'focus_area', 'description'
    ];

    // Relationships
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function poses()
    {
        return $this->hasMany(WeeklyPose::class);
    }
    public function weeklyPoses()
{
    return $this->hasMany(WeeklyPose::class);
}
}