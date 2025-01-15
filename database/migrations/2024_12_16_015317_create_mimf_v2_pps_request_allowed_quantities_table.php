<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMimfV2PpsRequestAllowedQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mimf_v2_pps_request_allowed_quantities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mimf_id')->comment = 'MIMF ID';
            $table->string('pps_whse_partnumber')->nullable();
            $table->unsignedTinyInteger('allowed_quantity')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
            $table->timestamps();

            $table->foreign('mimf_id')->references('id')->on('mimf_v2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mimf_v2_pps_request_allowed_quantities');
    }
}
