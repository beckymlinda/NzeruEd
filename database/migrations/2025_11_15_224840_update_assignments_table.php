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
    Schema::table('assignments', function (Blueprint $table) {
        $table->foreignId('course_id')->constrained()->cascadeOnDelete()->after('id');
        $table->string('title')->after('course_id');
        $table->text('instructions')->nullable()->after('title');
        $table->dateTime('due_at')->nullable()->after('instructions');
        $table->string('attachment')->nullable()->after('due_at');
    });
}

public function down(): void
{
    Schema::table('assignments', function (Blueprint $table) {
        $table->dropColumn(['course_id','title','instructions','due_at','attachment']);
    });
}

};
