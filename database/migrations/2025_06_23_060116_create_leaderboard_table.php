<?php
// database/migrations/2024_xx_xx_create_leaderboards_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id('leaderboard_id');
            $table->unsignedBigInteger('buyer_id');
            $table->enum('type', ['bulk_buyer', 'loyal_hunter', 'premium_collector']);
            $table->integer('exp')->default(0);
            $table->integer('total_items')->default(0);
            $table->integer('total_transactions')->default(0);
            $table->decimal('total_spent', 15, 2)->default(0);
            $table->timestamp('last_updated')->nullable();

            // Indexes untuk performance
            $table->index(['type', 'exp']);
            $table->unique(['buyer_id', 'type']);

            // Foreign key
            $table->foreign('buyer_id')->references('buyer_id')->on('buyers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leaderboards');
    }
};