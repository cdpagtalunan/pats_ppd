<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyFvisRuncardModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_fvis_runcard_mods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assembly_fvis_runcard_id')->references('id')->on('assembly_fvis_runcards');
            $table->foreignId('mod_id')->references('id')->on('defects_infos');
            $table->integer('qty');
            $table->foreignId('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('assembly_fvis_runcard_mods');
    }
}
