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
    Schema::create('assignments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('program_id')->nullable(); // optional if linked to program
        $table->string('title');
        $table->text('description')->nullable();
        $table->date('due_date');
        $table->string('media_path')->nullable(); // optional file (pdf, image, video)
        $table->timestamps();

        // If program_id exists, add foreign key
        $table->foreign('program_id')->references('id')->on('programs')->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
