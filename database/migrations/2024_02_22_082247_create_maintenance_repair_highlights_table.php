<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRepairHighlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_repair_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance_repair_highlights')->nullable();
            $table->string('in_charge')->nullable();
            $table->foreignId('machine_id')->references('id')->on('stamping_checksheet_machine_dropdowns');
            $table->string('date')->nullable();
            $table->smallInteger('status')->default(0);
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
        Schema::dropIfExists('maintenance_repair_highlights');
    }
}
