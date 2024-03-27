<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpInjectionVelocitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_injection_velocities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('machine_parameter_id')->unsigned();
            // $table->string('nozzle_set')->nullable()->default('N/A');

            $table->string('inj_v6')->nullable()->default('N/A');
            $table->string('inj_v5')->nullable()->default('N/A');
            $table->string('inj_v4')->nullable()->default('N/A');
            $table->string('inj_v3')->nullable()->default('N/A');
            $table->string('inj_v2')->nullable()->default('N/A');
            $table->string('inj_v1')->nullable()->default('N/A');
            $table->string('inj_fill')->nullable()->default('N/A');
            $table->string('inj_sv5')->nullable()->default('N/A');
            $table->string('inj_sv4')->nullable()->default('N/A');
            $table->string('inj_sv3')->nullable()->default('N/A');
            $table->string('inj_sv2')->nullable()->default('N/A');
            $table->string('inj_sv1')->nullable()->default('N/A');
            $table->string('inj_sm')->nullable()->default('N/A');
            $table->string('inj_sd')->nullable()->default('N/A');
            $table->string('inj_pp3')->nullable()->default('N/A');
            $table->string('inj_pp2')->nullable()->default('N/A');
            $table->string('inj_pp1')->nullable()->default('N/A');
            $table->string('inj_hold')->nullable()->default('N/A');
            $table->string('inj_tp2')->nullable()->default('N/A');
            $table->string('inj_tp1')->nullable()->default('N/A');
            $table->string('inj_pos_change_mode')->nullable()->default('N/A');
            $table->string('inj_pos_vs')->nullable()->default('N/A');
            $table->string('inj_pos_bp')->nullable()->default('N/A');
            $table->string('inj_pv3')->nullable()->default('N/A');
            $table->string('inj_pv2')->nullable()->default('N/A');
            $table->string('inj_pv1')->nullable()->default('N/A');
            $table->string('inj_sp2')->nullable()->default('N/A');
            $table->string('inj_sp1')->nullable()->default('N/A');
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
        Schema::dropIfExists('mp_injection_velocities');
    }
}
