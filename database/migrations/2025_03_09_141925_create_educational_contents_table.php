<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('educational_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->integer('duration');
            $table->boolean('is_visible')->default(true);
            $table->enum('key', ['physical_activity', 'meal', 'blood_sugar_reading', 'insulin_dose'])->nullable();
            $table->unsignedBigInteger('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educational_contents');
    }
};
