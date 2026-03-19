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
        Schema::create('weekly_poses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('weekly_target_id')->constrained()->cascadeOnDelete();
    $table->string('pose_name');
    $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('easy');
    $table->integer('hold_time_seconds')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_poses');
    }
};
