<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idUser');
            $table->string('username', 15)->nullable()->default(null)->unique();
            $table->string('email', 191)->nullable()->default(null)->unique();
            $table->string('fullName', 50)->nullable()->default(null);
            $table->string('idNumber', 9)->nullable()->default(null)->unique();
            $table->string('phoneNumber', 300)->nullable()->default(null);
            $table->string('avatar', 191)->nullable()->default(null);
            $table->date('dateOfBirth')->nullable()->default(null);
            $table->string('gender', 10)->nullable()->default(null);
            $table->text('addressUser')->nullable()->default(null);
            $table->tinyInteger('isActivated')->nullable()->default('0');
            $table->tinyInteger('isBanned')->nullable()->default('0');
            $table->string('remember_token', 191)->nullable()->default(null);
            $table->string('password', 191);
            $table->integer('pinCode')->nullable()->default(null);
            $table->integer('roleId')->default('1')->unsigned();

            $table->foreign('roleId')
                ->references('id')->on('roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->Timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
