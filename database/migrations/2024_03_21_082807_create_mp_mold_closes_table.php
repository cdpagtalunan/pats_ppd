<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpMoldClosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_mold_closes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('machine_parameter_id')->unsigned();
            $table->string('hi_v')->nullable()->default('N/A');
            $table->string('mid_slow')->nullable()->default('N/A');
            $table->string('low_v')->nullable()->default('N/A');
            $table->string('close_monitor_tm')->nullable()->default('N/A');
            $table->string('slow_start')->nullable()->default('N/A');
            $table->string('slow_end')->nullable()->default('N/A');
            $table->string('lvlp')->nullable()->default('N/A');
            $table->string('hpcl')->nullable()->default('N/A');
            $table->string('mid_sl_p')->nullable()->default('N/A');
            $table->string('low_p')->nullable()->default('N/A');
            $table->string('hi_p')->nullable()->default('N/A');
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
        Schema::dropIfExists('mp_mold_closes');
    }
}
