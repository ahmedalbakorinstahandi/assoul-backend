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

        Schema::create('blood_sugar_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->enum('measurement_type', ["fasting","befor_breakfast","befor_lunch","befor_dinner","after_snack","after_breakfast","after_lunch","after_dinner","befor_activity","after_activity"]);
            $table->decimal('value', 5, 2);
            $table->enum('unit', ["mg\/dL","mmol\/L"]);
            $table->text('notes')->nullable();
            $table->dateTime('measured_at');
            $table->bigInteger('measurementable_id')->nullable();
            $table->string('measurementable_type')->nullable();
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
        Schema::dropIfExists('blood_sugar_readings');
    }
};
