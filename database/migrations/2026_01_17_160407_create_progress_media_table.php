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
        Schema::create('progress_media', function (Blueprint $table) {
    $table->id();
    $table->foreignId('weekly_progress_id')->constrained()->cascadeOnDelete();
    $table->string('file_path');
    $table->enum('media_type', ['photo', 'video']);
    $table->boolean('is_best_of_week')->default(false);
    $table->string('caption')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_media');
    }
};
