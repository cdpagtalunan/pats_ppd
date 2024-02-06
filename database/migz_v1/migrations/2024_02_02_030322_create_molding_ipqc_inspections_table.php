<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoldingIpqcInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('molding_ipqc_inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_molding_id')->comment = 'id from molding table';
            $table->tinyInteger('molding_status')->comment = '1 - 1st Molding, 2 - 2nd Molding, 3 - Assembly';
            $table->string('pmi_po_no')->nullable();
            $table->string('judgement')->nullable();
            $table->string('output')->nullable();
            $table->string('ipqc_inspector_name')->nullable();
            $table->string('keep_sample')->nullable()->comment = '1 - Yes, 2 - No';
            $table->string('doc_no_b_drawing')->nullable()->comment = 'b drawing from acdcs';
            $table->string('doc_no_insp_standard')->nullable()->comment = 'inspection standard from acdcs';
            $table->string('doc_no_urgent_direction')->nullable()->comment = 'UD from acdcs';
            $table->string('measdata_attachment')->nullable();
            $table->string('ilqcm_attachment')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0-Pending, 1-Accepted, 2-Rejected';
            $table->tinyInteger('logdel')->default(0)->comment = '0-Active, 1-Deleted';
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('molding_ipqc_inspections');
    }
}
