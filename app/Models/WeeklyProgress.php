<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklyProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id', 'week_number', 'instructor_notes',
        'flexibility_score', 'strength_score', 'balance_score',
        'mindset_score', 'overall_feedback'
    ];

    // Relationships
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function media()
    {
        return $this->hasMany(ProgressMedia::class);
    }
    
    // ✅ ADD THIS (FIX)
    public function progressMedia()
    {
        return $this->hasMany(ProgressMedia::class);
    }
}
