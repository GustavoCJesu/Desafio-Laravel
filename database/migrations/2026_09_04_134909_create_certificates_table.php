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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class, 'instructor_id')->constrained('employees');
            $table->foreignIdFor(Employee::class, 'employee_id')->constrained('employees');
            $table->foreignIdFor(SessionTraining::class, 'session_training_id')->constrained('session_trainings');
            $table->date('confirmed_at');
            $table->date('expires_at');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
