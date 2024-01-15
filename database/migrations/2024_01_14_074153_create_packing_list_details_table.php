<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingListDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packing_list_details', function (Blueprint $table) {
            $table->id();
            $table->string('control_no')->nullable();
            $table->string('po_no')->nullable();
            $table->string('box_no')->nullable();
            $table->string('mat_name')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('quantity')->nullable();
            $table->string('pick_up_date')->nullable();
            $table->string('pick_up_time')->nullable();
            $table->string('product_from')->nullable();
            $table->string('product_to')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('port_of_destination')->nullable();
            // $table->string('sold_to')->nullable();
            // $table->string('ship_to')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('cc_personnel')->nullable();

            $table->tinyInteger('status')->default(0)->comment = '0-Active, 1-Deactivated';
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
        Schema::dropIfExists('packing_list_details');
    }
}
