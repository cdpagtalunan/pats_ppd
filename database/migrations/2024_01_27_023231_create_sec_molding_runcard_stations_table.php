<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecMoldingRuncardStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_molding_runcard_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sec_molding_runcard_id')->comment ='Id from sec_molding_runcards(table)';
            $table->string('station')->nullable();
            $table->string('date')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('input_quantity')->nullable();
            $table->tinyInteger('partial')->nullable()->comment = '0-No, 1-Yes';
            $table->string('ng_quantity')->nullable();
            $table->string('output_quantity')->nullable();
            $table->string('station_yield')->nullable();
            $table->longText('remarks')->nullable();

            $table->string('type_of_inspection')->nullable();
            $table->string('severity_of_inspection')->nullable();
            $table->string('inspection_level')->nullable();
            $table->string('lot_quantity')->nullable();
            $table->string('aql')->nullable();
            $table->string('sample_size')->nullable();
            $table->string('accept')->nullable();
            $table->string('reject')->nullable();
            $table->string('lot_inspected')->nullable();
            $table->string('lot_accepted')->nullable()->comment = "0-Rejected, 1-Acceepted";
            $table->string('judgement')->nullable()->comment = "0-Rejected, 1-Accepted";
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->tinyInteger('status')->default(0)->comment ='';
            $table->softDeletes()->comment ='0-Active, 1-Deleted';
            $table->timestamps();

            // Foreign Key
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_updated_by')->references('id')->on('users');
            $table->foreign('sec_molding_runcard_id')->references('id')->on('sec_molding_runcards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_molding_runcard_stations');
    }
}
