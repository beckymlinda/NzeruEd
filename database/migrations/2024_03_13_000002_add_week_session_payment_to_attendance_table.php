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
        Schema::table('attendance', function (Blueprint $table) {
            $table->integer('week_number')->after('recorded_by')->nullable();
            $table->integer('session_number')->after('week_number')->nullable();
            $table->string('payment_status')->after('session_number')->default('unpaid')->comment('unpaid, paid, partial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn(['week_number', 'session_number', 'payment_status']);
        });
    }
};
