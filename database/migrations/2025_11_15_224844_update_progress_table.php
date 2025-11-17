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
    Schema::table('progress', function (Blueprint $table) {
        $table->foreignId('user_id')->constrained()->cascadeOnDelete()->after('id');
        $table->foreignId('course_id')->constrained()->cascadeOnDelete()->after('user_id');
        $table->integer('lessons_completed')->default(0)->after('course_id');
        $table->integer('assignments_submitted')->default(0)->after('lessons_completed');
        $table->decimal('average_score',5,2)->nullable()->after('assignments_submitted');
    });
}

public function down(): void
{
    Schema::table('progress', function (Blueprint $table) {
        $table->dropColumn(['user_id','course_id','lessons_completed','assignments_submitted','average_score']);
    });
}

};
