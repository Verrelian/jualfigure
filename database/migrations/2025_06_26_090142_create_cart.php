<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id('cart_id');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();

            // Foreign keys
            $table->foreign('buyer_id')->references('buyer_id')->on('buyers')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');

            // Prevent duplicate cart items for same user + product
            $table->unique(['buyer_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};