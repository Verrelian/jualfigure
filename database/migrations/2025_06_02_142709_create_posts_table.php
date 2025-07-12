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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Foreign key ke buyer
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('buyer_id')
                ->on('buyers')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu
            $table->dropForeign(['user_id']);
        });

        // Drop tabel setelah foreign key dilepas
        Schema::dropIfExists('posts');
    }
};
