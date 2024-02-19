<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReelLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oqc_inspection_reel_lots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oqc_inspection_id');
            $table->unsignedTinyInteger('counter')->default(0);
            $table->string('reel_lot_no')->nullable();
            $table->string('reel_lot_qty')->nullable();
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
            $table->timestamps();

            $table->foreign('oqc_inspection_id')->references('id')->on('oqc_inspections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oqc_inspection_reel_lots');
    }
}
