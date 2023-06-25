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
        Schema::create('gym_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gym_id')->required();
            $table->string('name')->required();
            $table->string('image')->required();
            $table->string('price')->required();
            $table->string('desc');
            $table->foreign('gym_id')->references('id')->on('gyms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_prices');
    }
};
