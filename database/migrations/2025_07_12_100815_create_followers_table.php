<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follower_id');  // yang nge-follow
            $table->unsignedBigInteger('following_id'); // yang di-follow
            $table->timestamps();

            $table->unique(['follower_id', 'following_id']);

            $table->foreign('follower_id')->references('buyer_id')->on('buyers')->onDelete('cascade');
            $table->foreign('following_id')->references('buyer_id')->on('buyers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('followers');
    }
}
