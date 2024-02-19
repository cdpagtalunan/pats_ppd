<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionHistoryPartsMatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_history_parts_mats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prod_history_id')->references('id')->on('production_histories');
            $table->string('pm_group');
            $table->string('pm_name');
            $table->string('pm_code');
            $table->string('pm_lot_no');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('production_history_parts_mats');
    }
}
