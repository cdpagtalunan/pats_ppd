<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMimfV2PpsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mimf_v2_pps_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mimf_id')->comment = 'mimfs ID';
            $table->unsignedBigInteger('pps_whse_id')->comment = 'tbl_Warehouse ID';
            $table->unsignedBigInteger('pps_dieset_id')->nullable()->comment = 'For Molding - tbl_dieset ID';
            $table->unsignedBigInteger('ppd_mimf_matrix_id')->nullable()->comment = 'mimf_stamping_matrices ID';
            $table->unsignedBigInteger('ppd_matrix_id')->comment = 'For Molding';
            $table->unsignedTinyInteger('product_category')->nullable()->comment = 'For Molding';
            $table->string('material_code')->nullable();
            $table->string('material_type')->nullable();
            $table->unsignedTinyInteger('qty_invt')->nullable();
            $table->unsignedTinyInteger('request_qty')->nullable();
            $table->unsignedTinyInteger('multiplier')->nullable()->comment = 'For Molding';
            $table->unsignedTinyInteger('request_pins_pcs')->nullable()->comment = 'For 2nd Stamping';
            $table->unsignedTinyInteger('needed_kgs')->nullable();
            $table->unsignedTinyInteger('virgin_material')->nullable();
            $table->unsignedTinyInteger('recycled')->nullable();
            $table->string('prodn')->nullable();
            $table->string('delivery')->nullable();
            $table->string('remarks')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
            $table->timestamps();

            $table->foreign('mimf_id')->references('id')->on('mimf_v2');
            $table->foreign('ppd_mimf_matrix_id')->references('id')->on('mimf_v2_stamping_matrices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mimf_v2_pps_requests');
    }
}
