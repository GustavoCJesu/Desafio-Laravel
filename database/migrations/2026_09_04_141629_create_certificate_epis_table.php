<?php

use App\Models\Certificate;
use App\Models\Epi;
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
        Schema::create('certificate_epis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Certificate::class, 'certificate_id')->constrained('certificates')->cascadeOnDelete();
            $table->foreignIdFor(Epi::class, 'epi_id')->constrained('epis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_epis');
    }
};
