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
            $table->id();
            $table->string('prodn_date')->nullable();
            $table->string('machine_no')->nullable();
            $table->string('standard_para_date')->nullable();
            $table->string('standard_para_attachment')->nullable();
            $table->string('opt_id')->nullable();
            $table->string('prodn_stime')->nullable();
            $table->string('prodn_etime')->nullable();
            $table->string('act_cycle_time')->nullable();
            $table->string('shot_weight')->nullable();
            $table->string('product_weight')->nullable();
            $table->string('screw_most_fwd')->nullable();
            $table->string('ccd_setting_s1')->nullable();
            $table->string('ccd_setting_s2')->nullable();
            $table->string('ccd_setting_ng')->nullable();
            $table->string('changes_para')->nullable();
            $table->string('remarks')->nullable();
            $table->string('conducted_by')->nullable();
            $table->string('conducted_date')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('checked_date')->nullable();
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
