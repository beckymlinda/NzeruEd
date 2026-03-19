<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Create payment reminder notification
     */
    public static function createPaymentReminder($userId, $amount, $dueDate, $message = null)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => 'payment_reminder',
            'title' => 'Payment Reminder',
            'message' => $message ?: "You have a payment of MWK " . number_format($amount, 0) . " due on " . \Carbon\Carbon::parse($dueDate)->format('M d, Y'),
            'data' => [
                'amount' => $amount,
                'due_date' => $dueDate,
            ],
        ]);
        
        return $notification;
    }

    /**
     * Create payment due notification
     */
    public static function createPaymentDue($userId, $amount, $dueDate, $message = null)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => 'payment_due',
            'title' => 'Payment Due',
            'message' => $message ?: "Your payment of MWK " . number_format($amount, 0) . " is due today!",
            'data' => [
                'amount' => $amount,
                'due_date' => $dueDate,
            ],
        ]);
        
        return $notification;
    }

    /**
     * Create new assignment notification
     */
    public static function createAssignmentNotification($userId, $assignmentTitle, $dueDate, $message = null)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => 'assignment',
            'title' => 'New Assignment',
            'message' => $message ?: "You have a new assignment: {$assignmentTitle}",
            'data' => [
                'assignment_title' => $assignmentTitle,
                'due_date' => $dueDate,
            ],
        ]);
        
        return $notification;
    }

    /**
     * Create assignment reminder notification
     */
    public static function createAssignmentReminder($userId, $assignmentTitle, $dueDate, $message = null)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => 'assignment_reminder',
            'title' => 'Assignment Due Soon',
            'message' => $message ?: "Your assignment '{$assignmentTitle}' is due on " . \Carbon\Carbon::parse($dueDate)->format('M d, Y'),
            'data' => [
                'assignment_title' => $assignmentTitle,
                'due_date' => $dueDate,
            ],
        ]);
        
        return $notification;
    }

    /**
     * Create weekly pose notification
     */
    public static function createWeeklyPoseNotification($userId, $poseName, $weekNumber, $message = null)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => 'weekly_pose',
            'title' => 'New Weekly Pose',
            'message' => $message ?: "Check out this week's pose: {$poseName}",
            'data' => [
                'pose_name' => $poseName,
                'week_number' => $weekNumber,
            ],
        ]);
        
        return $notification;
    }

    /**
     * Create weekly pose reminder notification
     */
    public static function createWeeklyPoseReminder($userId, $poseName, $weekNumber, $message = null)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => 'weekly_pose_reminder',
            'title' => 'Weekly Practice Reminder',
            'message' => $message ?: "Don't forget to practice this week's pose: {$poseName}",
            'data' => [
                'pose_name' => $poseName,
                'week_number' => $weekNumber,
            ],
        ]);
        
        return $notification;
    }
}
