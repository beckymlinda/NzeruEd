<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'enrollment_id', 'session_date', 'status', 'reason', 'recorded_by', 'week_number', 'session_number', 'payment_status'
    ];

    protected $casts = [
        'session_date' => 'datetime',
    ];

    // Relationships
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
