<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpEjectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_ejectors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('machine_parameter_id')->unsigned();
            $table->string("pattern")->nullable()->default('N/A');
            $table->string("ej_pres")->nullable()->default('N/A');
            $table->string("fwd_ev1")->nullable()->default('N/A');
            $table->string("fwd_ev2")->nullable()->default('N/A');
            $table->string("stop_tm")->nullable()->default('N/A');
            $table->string("count")->nullable()->default('N/A');
            $table->string("ejt_tmg")->nullable()->default('N/A');
            $table->string("ev2_chg")->nullable()->default('N/A');
            $table->string("fwd_stop")->nullable()->default('N/A');
            $table->string("bwd_ev4")->nullable()->default('N/A');
            $table->string("bwd_prs")->nullable()->default('N/A');
            $table->string("repeat_bwd_stop")->nullable()->default('N/A');
            $table->string("repeat_fwd_stop")->nullable()->default('N/A');
            // Defaults
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // Foreign key
            $table->foreign('machine_parameter_id')->references('id')->on('machine_parameters'); // foreign id sa table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp_ejectors');
    }
}
