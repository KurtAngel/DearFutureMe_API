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
        Schema::create('received_capsules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('received_capsule_id');  
            $table->foreign('received_capsule_id')
                  ->references('id')->on('capsules');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_capsules');
    }
};
