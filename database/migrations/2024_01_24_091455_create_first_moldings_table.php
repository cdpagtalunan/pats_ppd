<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstMoldingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_moldings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('device_name')->comment = '1-CN171S-08#IN-VE, 2-CN171S-09#IN-R-VE, 3-CN171S-10#IN-L-VE';
            $table->string('contact_lot_number');
            $table->string('production_lot');
            $table->tinyInteger('status')->comment ='';
            $table->tinyInteger('logdel')->comment ='0-Active, 1-Deleted';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_moldings');
    }
}
