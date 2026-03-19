<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Enrollment;

class AddTestPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find enrollment for user ID 5
        $enrollment = Enrollment::where('user_id', 5)->where('status', 'active')->first();
        
        if ($enrollment) {
            // Create a test payment
            $payment = new Payment();
            $payment->enrollment_id = $enrollment->id;
            $payment->amount_paid = 50000.00;
            $payment->payment_date = now();
            $payment->payment_method = 'mobile_money';
            $payment->payment_frequency = 'monthly';
            $payment->notes = 'Test payment for demonstration';
            $payment->status = 'approved';
            $payment->save();
            
            $this->command->info("Added test payment of MWK 50,000 for enrollment {$enrollment->id}");
        } else {
            $this->command->info("No active enrollment found for user ID 5");
        }
    }
}
