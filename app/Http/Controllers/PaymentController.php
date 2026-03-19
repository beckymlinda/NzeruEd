<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Show payment form
     */
    public function create()
    {
        $enrollments = Enrollment::with('user', 'program')
            ->where('status', 'active')
            ->get();

        return view('admin.payments.create', compact('enrollments'));
    }

    /**
     * Show payment list
     */
    public function index()
    {
        $payments = Payment::with(['enrollment.user', 'enrollment.program'])
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Store payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'expected_amount' => 'required|numeric|min:1',
            'amount_paid'   => 'required|numeric|min:1',
            'payment_date'  => 'required|date',
            'payment_method' => 'required|string|max:50',
            'payment_frequency' => 'nullable|string|max:20',
            'notes'         => 'nullable|string|max:255',
        ]);

        Payment::create([
            'enrollment_id' => $request->enrollment_id,
            'expected_amount' => $request->expected_amount,
            'amount_paid'   => $request->amount_paid,
            'payment_date'  => $request->payment_date,
            'payment_method' => $request->payment_method,
            'payment_frequency' => $request->payment_frequency ?? 'one_time',
            'notes'         => $request->notes,
            'status'        => 'approved', // Set status to approved when recorded by admin
            'recorded_by'   => Auth::id(),
        ]);

        return redirect()
            ->route('admin.payments.create')
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Delete payment
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
