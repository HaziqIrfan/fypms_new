<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
    }
};
