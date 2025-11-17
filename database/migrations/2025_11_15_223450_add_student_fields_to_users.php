<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student'); // admin, teacher, student
            $table->unsignedTinyInteger('form_level')->nullable(); // 1..4
            $table->enum('payment_status', ['pending','approved','rejected'])->default('pending');
            $table->date('payment_expiry')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'form_level',
                'payment_status',
                'payment_expiry',
            ]);
        });
    }
};
