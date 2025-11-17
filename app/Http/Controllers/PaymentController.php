<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function uploadForm()
    {
        return view('payments.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $path = $request->file('proof')->store('payment_proofs');

        Payment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'proof_path' => $path,
            'status' => 'pending',
            'month_for' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('lessons.index')->with('success', 'Payment proof uploaded. Waiting for approval.');
    }
}
