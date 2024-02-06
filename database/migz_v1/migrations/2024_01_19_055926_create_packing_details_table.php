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
            $table->string('packing_ctrl_no')->nullable();
            $table->string('po_no')->nullable();
            $table->string('lot_qty')->nullable();
            $table->string('shipment_qty')->nullable();
            $table->string('material_name')->nullable();
            $table->string('material_lot_no')->nullable();
            $table->string('drawing_no')->nullable();
            $table->string('no_of_cuts')->nullable();
            $table->string('material_quality')->nullable();
            $table->integer('print_count')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0-For Packing List, 1-Completed';
            $table->string('validated_by_packer')->nullable();
            $table->string('validated_date_packer')->nullable();
            $table->string('validated_by_qc')->nullable();
            $table->string('validated_date_qc')->nullable();
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
