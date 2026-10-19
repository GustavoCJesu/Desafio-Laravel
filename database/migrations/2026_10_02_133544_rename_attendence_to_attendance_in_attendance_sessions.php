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
        Schema::rename('attendence_sessions', 'attendance_sessions');

        Schema::table('attendance_sessions', function (Blueprint $table) {
            $table->renameColumn('employee_attendence', 'employee_attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_sessions', function (Blueprint $table) {
            $table->renameColumn('employee_attendance', 'employee_attendence');
        });

        Schema::rename('attendance_sessions', 'attendence_sessions');
    }
};
