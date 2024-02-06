<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fkid_molding_devices');
            $table->tinyInteger('status')->default(0)->comment = '0-For IPQC, 1-Done IPQC, 2-Completed';
            $table->string('prodn_date');
            $table->string('shift');
            $table->string('machine_no');
            $table->string('standard_para_date');
            $table->string('standard_para_attach')->nullable();
            $table->string('act_cycle_time');
            $table->string('shot_weight');
            $table->string('product_weight');
            $table->string('screw_most_fwd');
            $table->string('ccd_setting_s1');
            $table->string('ccd_setting_s2');
            $table->string('ccd_setting_ng');
            $table->string('changes_para')->nullable();
            $table->string('remarks');
            $table->string('shots')->nullable();
            $table->string('prodn_stime')->nullable();
            $table->string('prodn_etime')->nullable();
            $table->string('material_name');
            $table->string('material_lot')->nullable();
            $table->string('opt_id');
            $table->string('qc_id')->nullable();
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
        Schema::dropIfExists('production_histories');
    }
}
