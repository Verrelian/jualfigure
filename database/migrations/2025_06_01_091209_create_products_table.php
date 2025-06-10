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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('product_name');
            $table->string('type');
            $table->integer('stock');
            $table->integer('sold')->nullable();
            $table->integer('price');
            $table->string('image');
            $table->text('description');
            $table->timestamps;
            $table->decimal('rating_total', 2, 1)->nullable();


            // Foreign key
            $table->foreign('seller_id')->references('seller_id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
