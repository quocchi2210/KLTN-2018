<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
	/**
	 * Schema table name to migrate
	 * @var string
	 */
	public $set_schema_table = 'orders';

	/**
	 * Run the migrations.
	 * @table orders
	 *
	 * @return void
	 */
	public function up() {
		if (Schema::hasTable($this->set_schema_table)) {
			return;
		}

		Schema::create($this->set_schema_table, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('idOrder');

			$table->unsignedInteger('idStore');
			$table->foreign('idStore')
				->references('idStore')->on('stores')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->string('billOfLading', 500)->nullable();
			$table->string('nameSender', 500)->nullable()->default(null);
			$table->string('addressSender', 500)->nullable()->default(null);
			$table->string('latitudeSender', 500)->nullable()->default(null);
			$table->string('longitudeSender', 500)->nullable()->default(null);
			$table->string('phoneSender', 500)->nullable()->default(null);
			$table->string('nameReceiver', 500)->nullable()->default(null);
			$table->string('addressReceiver', 500)->nullable()->default(null);
			$table->string('latitudeReceiver', 500)->nullable()->default(null);
			$table->string('longitudeReceiver', 500)->nullable()->default(null);
			$table->string('phoneReceiver', 500)->nullable()->default(null);
			$table->string('emailReceiver', 500)->nullable()->default(null);
			$table->string('descriptionOrder', 500);
			$table->string('COD', 500)->default('0');
			$table->string('timeDelivery', 500)->nullable()->default(null);
			$table->string('distanceShipping', 500);

			$table->string('totalWeight', 500);
			$table->string('priceService', 500);
			$table->string('totalMoney', 500);

			// $table->text('addressSender')->nullable()->default(null);
			// $table->decimal('latitudeSender', 11, 8)->nullable()->default(null);
			// $table->decimal('longitudeSender', 11, 8)->nullable()->default(null);
			// $table->string('phoneSender', 11)->nullable()->default(null);
			// $table->string('nameReceiver', 50)->nullable()->default(null);
			// $table->text('addressReceiver')->nullable()->default(null);
			// $table->decimal('latitudeReceiver', 11, 8)->nullable()->default(null);
			// $table->decimal('longitudeReceiver', 11, 8)->nullable()->default(null);
			// $table->string('phoneReceiver', 11)->nullable()->default(null);
			// $table->string('emailReceiver', 50)->nullable()->default(null);
			// $table->string('descriptionOrder', 50);
			// $table->tinyInteger('COD')->default('0');
			// $table->dateTime('timeDelivery')->nullable()->default(null);
			// $table->float('distanceShipping',4,1);
			// $table->float('totalWeight',4,2);
			// $table->double('priceService');
			// $table->double('totalMoney');

			$table->unsignedInteger('idServiceType');
			$table->foreign('idServiceType')
				->references('idService')->on('service_types')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->unsignedInteger('idShipper')->nullable();
			$table->foreign('idShipper')
				->references('idShipper')->on('shippers')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->unsignedInteger('idOrderStatus');
			$table->foreign('idOrderStatus')
				->references('idStatus')->on('order_status')
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
