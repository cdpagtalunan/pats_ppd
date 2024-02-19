<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyChecksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_checksheets', function (Blueprint $table) {
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
            $table->smallInteger('week')->nullable();
            $table->smallInteger('result_w1')->comment('1-Yes, 2-NG, 3-NA');
            $table->smallInteger('result_w2')->comment('1-Yes, 2-NG, 3-NA');
            $table->smallInteger('result_w3')->comment('1-Yes, 2-NG, 3-NA');
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
        Schema::dropIfExists('weekly_checksheets');
    }
}
