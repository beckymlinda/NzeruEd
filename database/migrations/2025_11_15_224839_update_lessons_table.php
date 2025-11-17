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
    Schema::table('lessons', function (Blueprint $table) {
        $table->foreignId('course_id')->constrained()->cascadeOnDelete()->after('id');
        $table->string('title')->after('course_id');
        $table->text('summary')->nullable()->after('title');
        $table->string('video_url')->nullable()->after('summary');
        $table->string('attachment_path')->nullable()->after('video_url');
        $table->boolean('is_free')->default(false)->after('attachment_path'); // free lesson toggle
        $table->integer('order')->default(0)->after('is_free');
    });
}

public function down(): void
{
    Schema::table('lessons', function (Blueprint $table) {
        $table->dropColumn(['course_id','title','summary','video_url','attachment_path','is_free','order']);
    });
}

};
