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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('product_name');
            $table->string('type');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('price_total');
            $table->string('address');
            $table->string('order_id');
            $table->string('image');
            $table->string('payment_code');
            $table->string('phone_number');
            $table->string('payment_method');
            $table->string('payment_status')->default('UNPAID');
            $table->string('transaction_status')->default('NOT YET PROCESSED');
            $table->timestamp('payment_date');
            $table->timestamp('expired_at')->nullable();

            // Foreign keys
            $table->foreign('seller_id')->references('seller_id')->on('sellers')->onDelete('cascade');
            $table->foreign('buyer_id')->references('buyer_id')->on('buyers')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
