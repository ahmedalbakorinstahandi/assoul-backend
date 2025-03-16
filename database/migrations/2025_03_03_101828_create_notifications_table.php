<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 6. Create Notifications Table
class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('title')->nullable();
            $table->text('message');
            $table->string('type', 50)->nullable();
            $table->timestamp('read_at')->nullable();
            $table->json('metadata')->nullable();
            $table->nullableMorphs('notifiable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
