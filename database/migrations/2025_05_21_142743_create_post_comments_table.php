<?php

// 2. Migration untuk post_comments (tanpa foreign key dulu)
// File: create_post_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comment');
            $table->timestamps();

            // Index untuk performa
            $table->index('post_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
