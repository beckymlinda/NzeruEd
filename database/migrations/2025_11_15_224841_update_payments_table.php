<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('payments', function (Blueprint $table) {
        $table->foreignId('user_id')->constrained()->cascadeOnDelete()->after('id');
        $table->integer('amount')->after('user_id'); // in MWK
        $table->string('proof_path')->after('amount'); // uploaded receipt
        $table->enum('status', ['pending','approved','rejected'])->default('pending')->after('proof_path');
        $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('status');
        $table->date('month_for')->nullable()->after('approved_by'); // the month fee covers
    });
}

public function down(): void
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropColumn(['user_id','amount','proof_path','status','approved_by','month_for']);
    });
}

};
