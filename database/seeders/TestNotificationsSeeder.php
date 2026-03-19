<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class TestNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get student user (ID 5)
        $student = User::find(5);
        
        if ($student) {
            // Create assignment notification
            Notification::create([
                'user_id' => $student->id,
                'type' => 'assignment',
                'title' => 'New Assignment',
                'message' => 'You have a new assignment: Yoga Journal Reflection',
                'data' => [
                    'assignment_title' => 'Yoga Journal Reflection',
                    'due_date' => now()->addDays(3)->toDateString(),
                ],
                'is_read' => false,
            ]);

            // Create assignment reminder
            Notification::create([
                'user_id' => $student->id,
                'type' => 'assignment_reminder',
                'title' => 'Assignment Due Soon',
                'message' => 'Your assignment "Yoga Journal Reflection" is due on ' . now()->addDays(3)->format('M d, Y'),
                'data' => [
                    'assignment_title' => 'Yoga Journal Reflection',
                    'due_date' => now()->addDays(3)->toDateString(),
                ],
                'is_read' => false,
            ]);

            // Create weekly pose notification
            Notification::create([
                'user_id' => $student->id,
                'type' => 'weekly_pose',
                'title' => 'New Weekly Pose',
                'message' => 'Check out this week\'s pose: Downward Facing Dog',
                'data' => [
                    'pose_name' => 'Downward Facing Dog',
                    'week_number' => 3,
                ],
                'is_read' => false,
            ]);

            // Create weekly pose reminder
            Notification::create([
                'user_id' => $student->id,
                'type' => 'weekly_pose_reminder',
                'title' => 'Weekly Practice Reminder',
                'message' => 'Don\'t forget to practice this week\'s pose: Downward Facing Dog',
                'data' => [
                    'pose_name' => 'Downward Facing Dog',
                    'week_number' => 3,
                ],
                'is_read' => false,
            ]);

            $this->command->info('Test notifications created for student ID 5');
        } else {
            $this->command->error('Student user with ID 5 not found');
        }
    }
}
