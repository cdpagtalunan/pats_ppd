<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingIpqcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_ipqcs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fs_productions_id')->comment = 'id from first_stamping_productions table';
            $table->tinyInteger('stamping_cat')->comment = '1 - 1st Stamping, 2 - 2nd Stamping';
            $table->string('po_number')->nullable();
            $table->string('part_code')->nullable();
            $table->string('material_name')->nullable();
            $table->string('prod_lot_no')->nullable();
            $table->string('judgement')->nullable();
            $table->string('input')->nullable();
            $table->string('output')->nullable();
            $table->unsignedBigInteger('ipqc_inspector_name')->nullable();
            $table->tinyInteger('keep_sample')->nullable()->comment = '1 - Yes, 2 - No';
            $table->string('doc_no_b_drawing')->nullable()->comment = 'b drawing from acdcs';
            $table->string('doc_no_insp_standard')->nullable()->comment = 'inspection standard from acdcs';
            $table->string('doc_no_urgent_direction')->nullable()->comment = 'UD from acdcs';
            $table->string('measdata_attachment')->nullable();
            $table->string('ilqcm_attachment')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0-Pending, 1-Updated:Accepted(J), 2-Updated:Rejected(J), 3-Submitted:Accepted(J), 4-Submitted:Rejected(J), 5-For Re-Inspection';
            $table->tinyInteger('logdel')->default(0)->comment = '0-Active, 1-Deleted';
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stamping_ipqcs');
    }
}
