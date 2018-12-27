<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
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
	public function up() {
		if (Schema::hasTable($this->set_schema_table)) {
			return;
		}

		Schema::create($this->set_schema_table, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('idUser');
			$table->string('username', 500)->nullable()->default(null)->unique();
			$table->string('email', 500)->nullable()->default(null);
			$table->string('fullName', 500)->nullable()->default(null);
			$table->string('idNumber', 500)->nullable()->default(null);
			$table->string('phoneNumber', 500)->nullable()->default(null);
			$table->string('avatar', 500)->nullable()->default(null);
			$table->string('dateOfBirth', 500)->nullable()->default(null);
			$table->string('gender', 500)->nullable()->default(null);
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
	public function down() {
		Schema::dropIfExists($this->set_schema_table);
	}
}
