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
        Schema::create('data_absen', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->text('location');
            $table->enum('status', ['success', 'failed']);
            $table->timestamp('time_absen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_absen');
    }
};