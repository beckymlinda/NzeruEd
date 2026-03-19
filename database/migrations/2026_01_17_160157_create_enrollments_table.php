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
       Schema::create('enrollments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('program_id')->constrained()->cascadeOnDelete();
    $table->date('start_date');
    $table->date('expected_end_date');
    $table->date('actual_end_date')->nullable();
    $table->integer('progress_percentage')->default(0);
    $table->enum('status', ['active', 'completed', 'renewed', 'dropped'])->default('active');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
