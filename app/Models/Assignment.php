<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'program_id',
        'title',
        'description',
        'due_date',
        'media_path',
    ];

protected $casts = [
    'due_date' => 'date',
];

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function assignedUsers()
{
    return $this->belongsToMany(User::class, 'assignment_user', 'assignment_id', 'user_id')
                ->withTimestamps();
}

}
