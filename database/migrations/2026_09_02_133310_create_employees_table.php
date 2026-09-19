<?php

use App\Models\CompanyRole;
use App\Models\Sector;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CompanyRole::class, 'company_role_id')->constrained('company_roles');
            $table->foreignIdFor(Sector::class, 'sector_id')->constrained('sectors');
            $table->string('registration');
            $table->string('name');
            $table->string('cpf');
            $table->date('hire_date');
            $table->date('departure_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
