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
    $table->string('username')->unique();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('address')->nullable();
    $table->integer('exp')->default(0);
    $table->text('bio')->nullable();
    $table->string('phone_number')->nullable();
    $table->string('avatar')->nullable();
    $table->timestamps();
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
