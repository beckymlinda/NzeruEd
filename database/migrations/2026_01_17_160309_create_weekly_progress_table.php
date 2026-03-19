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
        Schema::create('weekly_progress', function (Blueprint $table) {
    $table->id();
    $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
    $table->integer('week_number');
    $table->text('instructor_notes')->nullable();
    $table->tinyInteger('flexibility_score')->nullable();
    $table->tinyInteger('strength_score')->nullable();
    $table->tinyInteger('balance_score')->nullable();
    $table->tinyInteger('mindset_score')->nullable();
    $table->text('overall_feedback')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_progress');
    }
};
