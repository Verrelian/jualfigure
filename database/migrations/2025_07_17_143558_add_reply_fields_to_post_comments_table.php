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
        Schema::table('post_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('user_id');
            $table->tinyInteger('level')->default(0)->after('parent_id');

            // Foreign key untuk parent comment
            $table->foreign('parent_id')->references('id')->on('post_comments')->onDelete('cascade');

            // Index untuk performa query
            $table->index(['post_id', 'parent_id']);
            $table->index(['parent_id', 'level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['post_id', 'parent_id']);
            $table->dropIndex(['parent_id', 'level']);
            $table->dropColumn(['parent_id', 'level']);
        });
    }
};