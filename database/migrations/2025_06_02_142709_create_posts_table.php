<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; // Hati-hati di sini, ini harusnya `use Illuminate\Support\Facades\Schema;`

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Ini akan membuat kolom 'id' sebagai primary key
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // *** INI KODE BARU UNTUK user_id (Bukan buyer_id) ***
            $table->unsignedBigInteger('user_id'); // Kolom foreign key baru
            $table->foreign('user_id')
                  ->references('buyer_id') // Merujuk ke kolom 'buyer_id' di tabel 'buyers'
                  ->on('buyers')
                  ->onDelete('cascade');
            // ****************************************************

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};