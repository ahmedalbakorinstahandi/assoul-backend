<?php

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
        Schema::create('doctor_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('patient_id')->constrained('patients');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['doctor_id', 'patient_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_patients');
    }
};
