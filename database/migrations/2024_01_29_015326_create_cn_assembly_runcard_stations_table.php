<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnAssemblyRuncardStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cn_assembly_runcard_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cn_assembly_runcards_id')->comment ='Id from cn_assembly_runcards(table)';
            $table->string('station')->nullable();
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
            $table->foreign('cn_assembly_runcards_id')->references('id')->on('cn_assembly_runcards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cn_assembly_runcard_stations');
    }
}
