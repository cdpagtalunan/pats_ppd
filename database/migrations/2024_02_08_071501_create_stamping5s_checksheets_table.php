<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStamping5sChecksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping5s_checksheets', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status')->default(0);
            $table->longText('dis_remarks')->nullable();
            $table->string('assembly_line')->nullable();
            $table->string('dept')->nullable();
            $table->string('division')->nullable();
            $table->string('oic')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('conducted_by')->nullable();
            $table->string('shift')->nullable();
            $table->foreignId('machine_id')->references('id')->on('stamping_checksheet_machine_dropdowns');
            $table->string('remarks')->nullable();
            $table->smallInteger('checksheet_A_1_1')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_1_2')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_1_3')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_1_4')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_1_5')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_1_6')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_2_1')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_2_2')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_2_3')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_2_4')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->smallInteger('checksheet_A_3_1')->comment('1-Yes, 2-NG, 3-NA, 4-No work');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('stamping5s_checksheets');
    }
}
