<?php

use App\Models\Employee;
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
        Schema::create('training_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SessionTraining::class, 'session_training_id')->constrained('session_trainings')->cascadeOnDelete();
            $table->foreignIdFor(Employee::class, 'employee_id')->constrained('employees')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['session_training_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_employees');
    }
};
