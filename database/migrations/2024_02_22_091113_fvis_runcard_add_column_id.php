<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FvisRuncardAddColumnId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assembly_fvis_runcards', function (Blueprint $table) {
            $table->unsignedBigInteger('prod_runcard_station_id')->after('prod_runcard_id');
            $table->string('operator_name')->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assembly_fvis_runcards', function (Blueprint $table) {
            //
        });
    }
}
