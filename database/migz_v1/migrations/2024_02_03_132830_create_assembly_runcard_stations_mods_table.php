<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyRuncardStationsModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_runcard_stations_mods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('assembly_runcards_id')->references('id')->on('assembly_runcards')->comment ='Id from assembly_runcards(table)';
            $table->foreignId('assembly_runcard_stations_id')->references('id')->on('assembly_runcard_stations')->index('stations_foreign')->comment ='Id from assembly_runcard_stations(table)';
            $table->foreignId('mod_id')->references('id')->on('defects_infos')->index('defect_info_foreign')->comment ='Id from defects_infos(table)';
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
        Schema::dropIfExists('assembly_runcard_stations_mods');
    }
}
