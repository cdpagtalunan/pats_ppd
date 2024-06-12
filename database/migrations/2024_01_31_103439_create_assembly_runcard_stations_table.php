<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyRuncardStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_runcard_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assembly_runcards_id')->comment ='Id from assembly_runcards(table)';
            $table->string('station_step')->nullable();
            $table->string('date')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('input_quantity')->nullable();
            $table->string('ng_quantity')->nullable();
            $table->string('output_quantity')->nullable();
            $table->longText('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->tinyInteger('status')->default(0)->comment ='';
            $table->softDeletes()->comment ='0-Active, 1-Deleted';
            $table->timestamps();

            // Foreign Key
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_updated_by')->references('id')->on('users');
            $table->foreign('assembly_runcards_id')->references('id')->on('assembly_runcards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assembly_runcard_stations');
    }
}
