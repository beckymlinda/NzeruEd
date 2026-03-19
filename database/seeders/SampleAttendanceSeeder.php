<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Enrollment;
use Carbon\Carbon;

class SampleAttendanceSeeder extends Seeder
{
    public function run()
    {
        // Get all active enrollments
        $enrollments = Enrollment::where('status', 'active')->get();
        
        foreach ($enrollments as $enrollment) {
            // Add attendance for the last 7 days
            for ($i = 0; $i < 7; $i++) {
                $date = Carbon::now()->subDays($i);
                
                // Skip weekends (optional)
                if ($date->isWeekend()) {
                    continue;
                }
                
                // Create attendance record
                Attendance::firstOrCreate([
                    'enrollment_id' => $enrollment->id,
                    'session_date' => $date->format('Y-m-d'),
                    'week_number' => $enrollment->current_week ?? 1,
                    'session_number' => ($i % 3) + 1, // 1-3 sessions per day
                    'status' => 'present', // All present for streak demo
                    'payment_status' => 'paid',
                    'recorded_by' => 1 // Admin user ID (assuming admin has ID=1)
                ]);
            }
        }
        
        $this->command->info('Sample attendance data created for testing streak functionality!');
    }
}
