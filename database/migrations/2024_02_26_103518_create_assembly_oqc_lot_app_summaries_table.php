<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyOqcLotAppSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_oqc_lot_app_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('assy_oqc_lot_app_id')->references('id')->on('assembly_oqc_lot_apps')->comment ='assembly_oqc_lot_apps (table)';
            $table->unsignedTinyInteger('guaranteed_lot')->comment = '1-With,2-Without';
            $table->smallInteger('submission')->nullable();
            $table->string('problem')->nullable();
            $table->string('doc_no')->nullable();
            $table->string('remarks')->nullable();
            $table->string('operator_name')->nullable();
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
        Schema::dropIfExists('assembly_oqc_lot_app_summaries');
    }
}
