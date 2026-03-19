<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\User;

class PaymentReminderController extends Controller
{
    /**
     * Display payment reminders page
     */
    public function index()
    {
        // Get students with unpaid balances
        $studentsWithUnpaid = Enrollment::with(['user', 'program'])
            ->where('status', 'active')
            ->get()
            ->filter(function($enrollment) {
                $totalPaid = $enrollment->payments()->where('status', 'approved')->sum('amount_paid');
                $expectedAmount = $enrollment->payments()
                    ->whereNotNull('expected_amount')
                    ->sum('expected_amount') ?: 120000; // Default monthly rate
                return $totalPaid < $expectedAmount;
            });

        return view('admin.payment-reminders.index', compact('studentsWithUnpaid'));
    }

    /**
     * Create payment reminder for student
     */
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date|after:today',
            'message' => 'nullable|string|max:255',
        ]);

        // Create notification
        $notification = NotificationController::createPaymentReminder(
            $request->user_id,
            $request->amount,
            $request->due_date,
            $request->message
        );

        return redirect()
            ->route('admin.payment-reminders.index')
            ->with('success', 'Payment reminder sent successfully!');
    }

    /**
     * Send bulk payment reminders
     */
    public function sendBulkReminders(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:enrollments,id',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date|after:today',
            'message' => 'nullable|string|max:255',
        ]);

        $remindersSent = 0;
        foreach ($request->students as $enrollmentId) {
            $enrollment = Enrollment::find($enrollmentId);
            if ($enrollment) {
                NotificationController::createPaymentReminder(
                    $enrollment->user_id,
                    $request->amount,
                    $request->due_date,
                    $request->message
                );
                $remindersSent++;
            }
        }

        return redirect()
            ->route('admin.payment-reminders.index')
            ->with('success', "Payment reminders sent to {$remindersSent} students!");
    }
}
