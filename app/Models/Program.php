<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
use HasFactory;


protected $fillable = [
'title', 'description', 'duration_weeks', 'total_sessions', 'price', 'level'
];


public function enrollments()
{
return $this->hasMany(Enrollment::class);
}


public function weeklyTargets()
{
return $this->hasMany(WeeklyTarget::class);
}
}

