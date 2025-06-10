<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('specification', function (Blueprint $table) {
            $table->id('spec_id'); // PK
            $table->string('scale');
            $table->string('material');
            $table->string('manufacture');
            $table->date('release_date');
            $table->string('series');
            $table->unsignedBigInteger('product_id'); // FK ke products
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specification');
    }
};