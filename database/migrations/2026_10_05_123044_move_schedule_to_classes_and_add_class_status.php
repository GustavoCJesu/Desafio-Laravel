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
            $table->dropColumn('scheduled');
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->dateTime('class_dt')->change();
            $table->string('status')->default('Agendado')->after('class_dt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->date('class_dt')->change();
        });

        Schema::table('session_trainings', function (Blueprint $table) {
            $table->dateTime('scheduled')->useCurrent();
        });
    }
};
