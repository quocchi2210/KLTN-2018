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

            $table->unsignedInteger('idUser');
            $table->foreign('idUser')
                ->references('idUser')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedInteger('idStore');
            $table->foreign('idStore')
                ->references('idStore')->on('stores')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('billOfLading', 45)->nullable();
            $table->string('nameReceiver', 50)->nullable()->default(null);
            $table->text('addressReceiver')->nullable()->default(null);
            $table->decimal('latitudeReceiver', 8, 2)->nullable()->default(null);
            $table->decimal('longitudeReceiver', 8, 2)->nullable()->default(null);
            $table->string('phoneReceiver', 11)->nullable()->default(null);
            $table->string('emailReceiver', 50);
            $table->string('descriptionOrder', 50);
            $table->dateTime('dateCreated');
            $table->tinyInteger('COD')->default('0');
            $table->dateTime('timeDelivery');
            $table->integer('distanceShipping');

            $table->unsignedInteger('idServiceType');
            $table->foreign('idServiceType')
                ->references('idService')->on('service_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->tinyInteger('totalWeight');
            $table->double('totalPriceProduct');
            $table->double('priceService');
            $table->double('totalMoney');

            $table->unsignedInteger('idShipper');
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
