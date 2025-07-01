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
        Schema::create('shipping', function (Blueprint $table) {
            $table->id('shipping_id');
            $table->unsignedBigInteger('payment_id');
            $table->string('status');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('stage_index')->default(0);
            $table->timestamp('last_updated_at')->nullable()->default(now());
            $table->timestamps();

            // Foreign key
            $table->foreign('payment_id')->references('payment_id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};
