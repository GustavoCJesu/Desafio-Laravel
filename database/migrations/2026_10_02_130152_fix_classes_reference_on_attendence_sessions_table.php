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
        Schema::table('attendence_sessions', function (Blueprint $table) {
            $table->dropForeign(['session_treining_id']);
            $table->renameColumn('session_treining_id', 'classes_id');
        });

        Schema::table('attendence_sessions', function (Blueprint $table) {
            $table->foreign('classes_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->unique(['classes_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendence_sessions', function (Blueprint $table) {
            $table->dropUnique(['classes_id', 'employee_id']);
            $table->dropForeign(['classes_id']);
            $table->renameColumn('classes_id', 'session_treining_id');
        });

        Schema::table('attendence_sessions', function (Blueprint $table) {
            $table->foreign('session_treining_id')->references('id')->on('session_trainings');
        });
    }
};
