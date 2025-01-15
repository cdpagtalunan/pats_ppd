<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMimfV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mimf_v2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pps_po_rcvd_id')->comment = 'tbl_POReceived ID';
            $table->string('control_no')->nullable();
            $table->string('date_issuance')->nullable();
            $table->string('pmi_po_no')->nullable();
            $table->string('prodn_qty')->nullable();
            $table->string('device_code')->nullable();
            $table->string('device_name')->nullable();
            $table->string('created_by')->nullable()->comment = 'user login';
            $table->string('updated_by')->nullable()->comment = 'user login';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
            $table->unsignedTinyInteger('status')->default(0)->comment = '1-Stamping,2-Molding';
            $table->unsignedTinyInteger('category')->default(0)->comment = '1-First,2-Second';
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
        Schema::dropIfExists('mimf_v2');
    }
}
