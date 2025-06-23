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
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id('leaderboard_id');
            $table->unsignedBigInteger('buyer_id');
            $table->enum('type', ['bulk_buyer', 'loyal_hunter', 'premium_collector']);
            $table->integer('exp')->default(0);
            $table->timestamps();

            // Index for performance
            $table->index(['type', 'exp']);
            $table->unique(['buyer_id', 'type']); // Prevent duplicate entries

            // Foreign key
            $table->foreign('buyer_id')->references('buyer_id')->on('buyers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};