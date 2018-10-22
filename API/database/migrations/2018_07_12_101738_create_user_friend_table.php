<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFriendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_friend', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('friend_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('friend_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('accepted')->default(0);
            $table->tinyInteger('followed')->default(0);
            $table->tinyInteger('blocked')->default(0);
            $table->primary(array('user_id', 'friend_id'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_friend');
    }
}
