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
        Schema::table('session_trainings', function (Blueprint $table) {
            $table->string('norm', 10)->after('instructor_id');
            $table->unsignedInteger('capacity')->after('class_min');
            $table->string('location')->nullable()->after('capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_trainings', function (Blueprint $table) {
            $table->dropColumn(['norm', 'capacity', 'location']);
        });
    }
};
