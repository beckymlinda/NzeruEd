<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'form_level', 'payment_status', 'payment_expiry'
    ];

    protected $dates = [
        'payment_expiry',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function coursesTeaching()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'progress')
                    ->withPivot('lessons_completed', 'assignments_submitted', 'average_score');
    }

    // Role helpers
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function hasAccess()
    {
        if ($this->isAdmin()) return true;
        if ($this->isTeacher()) return true;

        if ($this->payment_status === 'approved' && $this->payment_expiry) {
            return $this->payment_expiry->isFuture();
        }

        return false;
    }
}
