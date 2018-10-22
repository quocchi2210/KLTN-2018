<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('country_code')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->integer('role_id')->unsigned()->default(1);
            $table->foreign('role_id')->references('role_id')->on('role')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('disabled')->default(0);
            $table->tinyInteger('locked')->default(0);
            $table->string('password');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->decimal('init_lat')->nullable();
            $table->decimal('init_lng')->nullable();
            $table->string('address')->nullable();
            $table->string('about')->nullable();
            $table->string('qr_code')->unique();
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
        Schema::dropIfExists('users');
    }
}
