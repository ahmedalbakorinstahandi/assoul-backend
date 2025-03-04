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

        Schema::create('insulin_doses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('taken_date');
            $table->enum('taken_time', ["befor_breakfast_2h","befor_lunch_2h","befor_dinner_2h"]);
            $table->string('insulin_type');
            $table->double('dose_units');
            $table->enum('injection_site', ["arm","thigh","abdomen","lower_back"]);
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
        Schema::dropIfExists('insulin_doses');
    }
};
