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
        Schema::create('receivedCapsules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('title');
            $table->string('message');
            $table->text('content')->nullable();
            $table->string('receiver_email');
            $table->foreign('receiver_email')
                ->references('email')
                ->on('users')
                ->onDelete('cascade');
            $table->dateTime('scheduled_open_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivedCapsules');
    }
};
