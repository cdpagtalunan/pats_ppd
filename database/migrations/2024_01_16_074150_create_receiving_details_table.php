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
            $table->integer('prod_id');
            $table->string('po_no')->nullable();
            $table->string('part_code')->nullable();
            $table->string('control_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('mat_name')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('quantity')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('supplier_lot_no')->nullable();
            $table->string('supplier_quantity')->nullable();
            $table->string('supplier_pmi_lot_no')->nullable();
            $table->string('updated_by')->nullable();
            
            $table->tinyInteger('status')->default(0)->comment = '0-For Whse edit, 1-for IQC Inspection, 2-Accepted';
            $table->integer('printing_status')->default(0)->comment = '0-For Printing, 1-Reprint';

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
