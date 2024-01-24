<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packing_details', function (Blueprint $table) {
            $table->id();
            $table->integer('oqc_id');
            $table->string('delivery_balance')->nullable();
            $table->string('no_of_cuts')->nullable();
            $table->string('material_quality')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0-For Packing List, 1-Completed';
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
        Schema::dropIfExists('packing_details');
    }
}
