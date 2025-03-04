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

        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('consumed_date');
            $table->enum('type', ["breakfast","lunch","dinner","snack"]);
            $table->string('carbohydrates_calories')->nullable();
            $table->text('description')->comment('وصف الوجبة (مثل: أرز + دجاج)');
            $table->text('notes')->nullable()->comment('ملاحظات (مثل: شعور بالشبع)');
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
        Schema::dropIfExists('meals');
    }
};
