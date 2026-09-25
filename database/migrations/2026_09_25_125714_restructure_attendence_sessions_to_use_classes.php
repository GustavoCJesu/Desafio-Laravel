<?php

use App\Models\Classes;
use App\Models\SessionTraining;
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
            $table->dropColumn(['session_treining_id', 'class_dt']);
            $table->foreignIdFor(Classes::class, 'classes_id')->after('id')->constrained('classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendence_sessions', function (Blueprint $table) {
            $table->dropForeign(['classes_id']);
            $table->dropColumn('classes_id');
            $table->foreignIdFor(SessionTraining::class, 'session_treining_id')->constrained('session_trainings');
            $table->date('class_dt');
        });
    }
};
