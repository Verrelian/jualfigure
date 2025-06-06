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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id('buyer_id');
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('address');
            $table->integer('exp');
            $table->string('bio');
            $table->bigInteger('phone_number');
            // tanpa timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
