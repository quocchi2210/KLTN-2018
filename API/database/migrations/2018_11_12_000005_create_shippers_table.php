<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippersTable extends Migration {
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $set_schema_table = 'shippers';

	/**
	 * Run the migrations.
	 * @table shippers
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable($this->set_schema_table)) {
			return;
		}

		Schema::create($this->set_schema_table, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('idShipper');
			$table->unsignedInteger('idUser');
			$table->string('licensePlates', 300)->nullable()->default(null);
			$table->string('latitudeShipper', 300)->nullable()->default(null);
			$table->string('longitudeShipper', 300)->nullable()->default(null);
			// $table->decimal('latitudeShipper', 11, 8)->nullable()->default(null);
			// $table->decimal('longitudeShipper', 11, 8)->nullable()->default(null);

			$table->foreign('idUser')
				->references('idUser')->on('users')
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
