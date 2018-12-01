<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTrackingsTable extends Migration
{
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
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
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

            $table->decimal('latitude', 8,2)->nullable();
            $table->decimal('longitude', 8,2)->nullable();

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
