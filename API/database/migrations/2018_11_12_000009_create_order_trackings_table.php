<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTrackingsTable extends Migration {
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $set_schema_table = 'order_trackings';

	/**
	 * Run the migrations.
	 * @table order_tracking
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable($this->set_schema_table)) {
			return;
		}

		Schema::create($this->set_schema_table, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('idTracking');
			$table->unsignedInteger('idOrder')->nullable();
			$table->foreign('idOrder')
				->references('idOrder')->on('orders')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->unsignedInteger('idShipper')->nullable();
			$table->foreign('idShipper')
				->references('idShipper')->on('shippers')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->string('latitude', 500)->nullable();
			$table->string('longitude', 500)->nullable();

			// $table->decimal('latitude', 11,8)->nullable();
			// $table->decimal('longitude', 11,8)->nullable();

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
