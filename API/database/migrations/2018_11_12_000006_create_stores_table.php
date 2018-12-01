<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'stores';

    /**
     * Run the migrations.
     * @table stores
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idStore');

            $table->unsignedInteger('idUser');
            $table->foreign('idUser')
                ->references('idUser')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('nameStore', 50)->nullable()->default(null);
            $table->string('typeStore', 50)->nullable()->default(null);
            $table->string('addressStore', 100)->nullable()->default(null);
            $table->string('descriptionStore', 100)->nullable()->default(null);
            $table->decimal('latitudeStore', 8, 2)->nullable()->default(null);
            $table->decimal('longitudeStore', 8, 2)->nullable()->default(null);
            $table->time('startWorkingTime')->nullable()->default(null);
            $table->time('endWorkingTime')->nullable()->default(null);



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
