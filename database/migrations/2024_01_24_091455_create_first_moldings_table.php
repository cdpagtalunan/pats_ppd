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
            $table->bigInteger('first_molding_device_id ')->constrained()->comment = '1-CN171S-08#IN-VE, 2-CN171S-09#IN-R-VE, 3-CN171S-10#IN-L-VE';
            $table->string('production_lot')->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment ='';
            $table->string('remarks')->nullable();
            $table->softDeletes()->nullable();
            // $table->tinyInteger('logdel')->nullable()->comment ='0-Active, 1-Deleted';
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
