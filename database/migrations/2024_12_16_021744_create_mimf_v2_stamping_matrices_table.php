<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMimfV2StampingMatricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mimf_v2_stamping_matrices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stamping_pps_whse_id')->nullable()->comment = 'tbl_Warehouse';
            $table->string('pin_kg')->nullable();
            $table->string('created_by')->nullable()->comment = 'user login';
            $table->string('updated_by')->nullable()->comment = 'user login';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
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
        Schema::dropIfExists('mimf_v2_stamping_matrices');
    }
}
