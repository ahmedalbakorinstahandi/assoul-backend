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
        Schema::disableForeignKeyConstraints();

        Schema::create('physical_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('activity_date')->nullable();
            $table->enum('activity_time', ["6-8", "8-10", "10-12", "12-14", "14-16", "16-18", "18-20", "20-22"]);
            $table->string('description')->nullable();
            $table->enum('intensity', ["low", "moderate", "high"]);
            $table->integer('duration');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_activities');
    }
};
