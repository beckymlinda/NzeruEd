<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class UpdatePendingPaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendingPayments = Payment::where('status', 'pending')->get();
        
        foreach ($pendingPayments as $payment) {
            $payment->status = 'approved';
            $payment->save();
            
            $this->command->info("Updated payment #{$payment->id} from 'pending' to 'approved'");
        }
        
        $this->command->info("Successfully updated {$pendingPayments->count()} payments to 'approved' status");
    }
}
