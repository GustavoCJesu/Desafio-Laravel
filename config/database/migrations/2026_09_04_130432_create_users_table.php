<?php

use App\Models\Employee;
use App\Models\UserRole;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class, 'employee_id')->nullable()->constrained('employees');
            $table->foreignIdFor(UserRole::class, 'user_role_id')->nullable()->constrained('user_roles');
            $table->string('email');
            $table->string('password');
            $table->boolean('softdel')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
