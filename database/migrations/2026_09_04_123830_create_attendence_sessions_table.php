<?php

use App\Models\Classes;
use App\Models\Employee;
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
        Schema::create('attendence_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Classes::class, 'session_treining_id')->constrained('session_trainings');
            $table->foreignIdFor(Employee::class, 'employee_id')->constrained('employees');
            $table->string('employee_attendence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendence_sessions');
    }
};
