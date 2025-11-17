<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id','title','summary','video_url','attachment_path','is_free','order'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
