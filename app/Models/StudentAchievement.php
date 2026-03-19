<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id', 'achievement_id', 'awarded_week', 'notes'
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
}
