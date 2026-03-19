<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'status', 'profile_photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to dates.
     */
    protected $dates = [
        'payment_expiry',
        'created_at',
        'updated_at',
    ];

    // -------------------
    // Relationships
    // -------------------

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function coursesTeaching()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }
 

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }
// App\Models\User.php

protected $casts = [
    'assignments_last_seen_at' => 'datetime',
];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'progress')
                    ->withPivot('lessons_completed', 'assignments_submitted', 'average_score');
    }

    // -------------------
    // Role helpers
    // -------------------

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

    // -------------------
    // Access check
    // -------------------

    public function hasAccess()
    {
        if ($this->isAdmin() || $this->isTeacher()) {
            return true;
        }

        if ($this->payment_status === 'approved' && $this->payment_expiry) {
            return $this->payment_expiry->isFuture();
        }

        return false;
    }
    public function assignments()
{
    return $this->belongsToMany(Assignment::class, 'assignment_user', 'user_id', 'assignment_id')
                ->withTimestamps();
}

public function weeklyPoses()
{
    return $this->belongsToMany(WeeklyPose::class, 'weekly_pose_student', 'user_id', 'weekly_pose_id');
}

}
