<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'order_details';

    /**
     * Run the migrations.
     * @table order_details
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idOrderDetail');

            $table->unsignedInteger('idOrder');
            $table->foreign('idOrder')
                ->references('idOrder')->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('nameProduct', 50)->nullable()->default(null);
            $table->double('priceProduct');
            $table->integer('quantityProduct');
            $table->string('imgProduct', 191);
            $table->double('amountMoney');





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
