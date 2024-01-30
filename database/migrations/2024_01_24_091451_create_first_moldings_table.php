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
            $table->bigInteger('first_molding_device_id')->unsigned()->comment = '1-CN171S-08#IN-VE, 2-CN171S-09#IN-R-VE, 3-CN171S-10#IN-L-VE';
            $table->string('contact_lot_number')->nullable();
            $table->string('production_lot')->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment ='';
            $table->string('remarks')->nullable();
            $table->softDeletes()->nullable();
            $table->timestamps();
            $table->foreign('first_molding_device_id')->references('id')->on('first_molding_devices');
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
