<?php

use App\Models\Permission;
use App\Models\User_Role;
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
        Schema::create('role__permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User_Role::class, 'user_role_id')->constrained('user__roles');
            $table->foreignIdFor(Permission::class, 'permission_id')->constrained('permissions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role__permissions');
    }
};

