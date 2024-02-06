<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstMoldingDetailModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_molding_detail_mods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('first_molding_detail_id')->references('id')->on('first_molding_details')->comment ='Reference to first_molding_stations id(table)';
            $table->foreignId('defects_info_id')->unsigned()->references('id')->on('defects_infos')->comment ='Reference to defects_infos id(table)(table)';
            $table->integer('mod_quantity')->nullable();
            $table->foreignId('last_updated_by')->nullable()->references('id')->on('users');
            $table->tinyInteger('status')->default(0)->comment ='';
            $table->softDeletes();
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
        Schema::dropIfExists('first_molding_detail_mods');
    }
}
