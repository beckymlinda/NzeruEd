<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('courses', function (Blueprint $table) {
        $table->string('title'); // add column
        $table->string('subject'); // Math, Biology, etc.
        $table->unsignedTinyInteger('form_level'); // 1..4
        $table->text('description')->nullable();
        $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('courses', function (Blueprint $table) {
        $table->dropColumn(['title', 'subject', 'form_level', 'description', 'teacher_id']);
    });
}


};
