<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyOqcLotAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_oqc_lot_apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('assy_fvi_id')->references('id')->on('assembly_fvis')->comment ='assembly_fvis (table)';
            $table->string('po_no', 30)->nullable();
            $table->smallInteger('status')->nullable()->comment = '0 = Prodn Approval, 1 = QC Approval, 2 = Done';
            $table->smallInteger('submission')->nullable();
            $table->smallInteger('device_cat')->nullable()->comment = '1-Automotive,2-Non-Automotive';
            $table->smallInteger('cert_lot')->nullable()->comment = '1-New Operator,2-New product/model,3-Evaluation lot,4-Re-inspection,5-Flexibility';
            $table->string('assy_line', 50)->nullable();
            $table->string('lot_batch_no');
            $table->string('FVO_empid', 20);
            $table->string('reel_lot')->nullable();
            $table->string('print_lot');
            $table->string('lot_qty');
            $table->string('direction')->nullable();
            $table->string('drawing', 100);
            $table->string('ttl_reel')->nullable();
            $table->string('app_date');
            $table->time('app_time');
            $table->unsignedTinyInteger('guaranteed_lot')->comment = '1-With,2-Without';
            $table->string('problem')->nullable();
            $table->string('doc_no')->nullable();
            $table->string('remarks')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('oqc_supervisor')->nullable();
            $table->string('ww')->nullable();
            $table->softDeletes()->comment ='0-Active, 1-Deleted';
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
        Schema::dropIfExists('assembly_oqc_lot_apps');
    }
}
