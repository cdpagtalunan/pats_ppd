<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_processes', function (Blueprint $table) {
            $table->id();
            $table->string('step');
            $table->string('process')->comment = "from processes";
            $table->unsignedBigInteger('device_id')->comment = "devices table";
            // $table->string('material_id')->comment = "PPSMIS";
            // $table->string('material_name')->comment = "PPSMIS";
            $table->string('machine_code')->nullable()->comment = "EEDMS generallogistics table";
            $table->string('machine_name')->nullable()->comment = "EEDMS generallogistics table";
            $table->string('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();


            $table->foreign('device_id')->references('id')->on('devices');
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
        Schema::dropIfExists('material_processes');
    }
}
