<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpHeatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_heaters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('machine_parameter_id')->unsigned();
            $table->string('nozzle_set')->nullable()->default('N/A');
            $table->string('front_set')->nullable()->default('N/A');
            $table->string('mid_set')->nullable()->default('N/A');
            $table->string('rear_set')->nullable()->default('N/A');
            $table->string('nozzle_actual')->nullable()->default('N/A');
            $table->string('front_actual')->nullable()->default('N/A');
            $table->string('mid_actual')->nullable()->default('N/A');
            $table->string('rear_actual')->nullable()->default('N/A');
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
        Schema::dropIfExists('mp_heaters');
    }
}
