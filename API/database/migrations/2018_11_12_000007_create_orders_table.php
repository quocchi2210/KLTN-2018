<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
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
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idOrder');

            $table->unsignedInteger('idStore');
            $table->foreign('idStore')
                ->references('idStore')->on('stores')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('billOfLading', 300)->nullable();
            $table->string('nameSender', 300)->nullable()->default(null);
            $table->string('addressSender',300)->nullable()->default(null);
            $table->string('latitudeSender',300)->nullable()->default(null);
            $table->string('longitudeSender',300)->nullable()->default(null);
            $table->string('phoneSender',300)->nullable()->default(null);
            $table->string('nameReceiver', 300)->nullable()->default(null);
            $table->string('addressReceiver',300)->nullable()->default(null);
            $table->string('latitudeReceiver',300)->nullable()->default(null);
            $table->string('longitudeReceiver',300)->nullable()->default(null);
            $table->string('phoneReceiver',300)->nullable()->default(null);
            $table->string('emailReceiver',300)->nullable()->default(null);
            $table->string('descriptionOrder',300);
            $table->string('COD',300)->default('0');
            $table->string('timeDelivery',300)->nullable()->default(null);
            $table->string('distanceShipping',300);

            $table->string('totalWeight',300);
            $table->string('priceService',300);
            $table->string('totalMoney',300);

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
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
