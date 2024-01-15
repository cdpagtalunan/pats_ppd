<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIqcInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iqc_inspections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('whs_transaction_id');
            $table->bigInteger('invoice_no');
            /*
            'invoice_no'=>'required',
            'partcode'=>'required',
            'partname'=>'required',
            'supplier'=>'required',
            'family'=>'required',
            'app_no'=>'required',
            'app_no_extension'=>'required',
            'die_no'=>'required',
            'total_lot_qty'=>'required',
            'type_of_inspection'=>'required',
            'severity_of_inspection'=>'required',
            'inspection_lvl'=>'required',
            'aql'=>'required',
            'accept'=>'required',
            'reject'=>'required',
            'shift'=>'required',
            'time_ins_from'=>'required',
            'time_ins_to'=>'required',
            'inspector'=>'required',
            'submission'=>'required',
            'category'=>'required',
            'target_lar'=>'required',
            'target_dppm'=>'required',
            'sampling_size'=>'required',
            'lot_inspected'=>'required',
            'accepted'=>'required',
            'judgement'=>'required',.
            */
            $table->softDeletes();
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
        Schema::dropIfExists('iqc_inspections');
    }
}
