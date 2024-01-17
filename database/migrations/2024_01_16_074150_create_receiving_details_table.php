<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiving_details', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('prod_id');
            $table->string('control_no')->nullable();
            $table->string('mat_name')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('quantity')->nullable();
            $table->string('sanno_lot_no')->nullable();
            $table->string('sanno_quantity')->nullable();
            $table->string('sanno_pmi_lot_no')->nullable();
            $table->string('updated_by')->nullable();

            $table->tinyInteger('status')->default(0)->comment = '0-For Whse edit, 1-for IQC Inspection';

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
        Schema::dropIfExists('receiving_details');
    }
}
