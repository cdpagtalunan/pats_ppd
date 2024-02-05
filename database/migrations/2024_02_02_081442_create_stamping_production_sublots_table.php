<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingProductionSublotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_production_sublots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stamp_prod_id')->comment = "From stamping_productions table";
            $table->bigInteger('counter');
            $table->integer('batch_qty');
            $table->integer('packing_status')->default(0)->comment = '0- For Packing, 1-For QC, 2-Completed';
            $table->timestamps();

            $table->foreign('stamp_prod_id')->references('id')->on('stamping_productions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stamping_production_sublots');
    }
}
