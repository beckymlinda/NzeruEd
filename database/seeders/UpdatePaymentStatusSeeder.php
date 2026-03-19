<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class UpdatePaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = Payment::whereNull('status')->get();
        
        foreach ($payments as $payment) {
            $payment->status = 'approved';
            $payment->save();
            
            $this->command->info("Updated payment {$payment->id} status to 'approved'");
        }
        
        $this->command->info("Successfully updated {$payments->count()} payments to 'approved' status");
    }
}
