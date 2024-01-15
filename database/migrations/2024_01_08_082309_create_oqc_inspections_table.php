<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOQCInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oqc_inspections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fs_productions_id')->unsigned();
            $table->string('po_no')->nullable();
            $table->string('po_qty')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('lot_qty')->nullable();
            $table->string('assembly_line')->nullable();
            $table->string('fy')->nullable();
            $table->string('ww')->nullable();
            $table->string('date_inspected')->nullable();
            $table->string('material_name')->nullable();
            $table->string('time_ins_from')->nullable();
            $table->string('time_ins_to')->nullable();
            $table->string('submission')->nullable();
            $table->string('sample_size')->nullable();
            $table->string('num_of_defects')->nullable();
            $table->string('judgement')->nullable();
            $table->string('inspector')->nullable();
            $table->string('remarks')->nullable();
            $table->string('shift')->nullable();
            $table->string('app_date')->nullable();
            $table->string('app_time')->nullable();
            $table->string('prod_category')->nullable();
            $table->string('customer')->nullable();
            $table->string('family')->nullable();
            $table->string('type_of_inspection')->nullable();
            $table->string('severity_of_inspection')->nullable();
            $table->string('inspection_lvl')->nullable();
            $table->string('aql')->nullable();
            $table->string('accept')->nullable();
            $table->string('reject')->nullable();
            $table->string('coc_req')->nullable();
            $table->string('lot_inspected')->nullable();
            $table->string('lot_accepted')->nullable();
            $table->string('update_user')->nullable();
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
            $table->timestamps();

            // Foreign Key
            $table->foreign('stamping_ipqcs_id')->references('id')->on('stamping_ipqcs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oqc_inspections');
    }
}
