<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecMoldingRuncardStationModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_molding_runcard_station_mods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('sec_molding_runcard_id')->references('id')->on('sec_molding_runcards')->comment ='Id from sec_molding_runcards(table)';
            $table->foreignId('sec_molding_runcard_station_id')->references('id')->on('sec_molding_runcard_stations')->index('piningeer')->comment ='Id from sec_molding_runcard_stations(table)';
            $table->foreignId('mod_id')->references('id')->on('defects_infos')->index('mod_id_foreign')->comment ='Id from defects_infos(table)';
            $table->string('mod_quantity')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users');
            $table->foreignId('last_updated_by')->nullable()->references('id')->on('users');
            $table->tinyInteger('status')->default(0)->comment ='';
            $table->softDeletes()->comment ='0-Active, 1-Deleted';
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
        Schema::dropIfExists('sec_molding_runcard_station_mods');
    }
}
