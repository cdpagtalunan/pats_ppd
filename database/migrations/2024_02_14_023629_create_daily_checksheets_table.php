<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyChecksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_checksheets', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status')->default(0);
            $table->smallInteger('unit_no')->nullable();
            $table->foreignId('machine_id')->references('id')->on('stamping_checksheet_machine_dropdowns');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('division')->nullable();
            $table->string('area')->nullable();
            $table->string('month')->nullable();
            $table->string('conformed_by')->nullable();
            $table->string('actual_measurement_d1')->nullable();
            $table->string('actual_measurement_d2')->nullable();
            $table->smallInteger('result_d1')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d2')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d3')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d4')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d5')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d6')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d7')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d8')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d9')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d10')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d11')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d12')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->smallInteger('result_d13')->comment('1-Yes, 2-NG, 3-NP, 4-NA');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->string('conducted_by_operator')->nullable();
            $table->string('checked_by_engineer')->nullable();
            $table->string('conformed_by_qc')->nullable();
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
        Schema::dropIfExists('daily_checksheets');
    }
}
