<?php

use App\Models\Epi;
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
        Schema::create('training_epis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SessionTraining::class, 'session_training_id');
            $table->foreignIdFor(Epi::class, 'epi_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_epis');
    }
};
