<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusDetailsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'order_status_details';

    /**
     * Run the migrations.
     * @table order_status_details
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('idOrder');
            $table->foreign('idOrder')
                ->references('idOrder')->on('orders')
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
