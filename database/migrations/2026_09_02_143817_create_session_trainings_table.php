<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('session_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class, 'instructor_id')->constrained('employees');
            $table->string('title');
            $table->string('description');
            $table->dateTime('scheduled');
            $table->string('status');
            $table->integer('class_amount');
            $table->integer('class_min');
            $table->date('validity_dt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('session_trainings');
    }
};
