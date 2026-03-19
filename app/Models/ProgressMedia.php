<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_progress_id', 'file_path', 'media_type', 'is_best_of_week', 'caption'
    ];

    // Relationships
    public function weeklyProgress()
    {
        return $this->belongsTo(WeeklyProgress::class);
    }
}
