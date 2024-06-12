<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyPreProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_pre_prods', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status')->default(0);
            $table->string('equipment_name')->nullable();
            $table->string('machine_code')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('month')->nullable();
            $table->string('shift')->nullable();
            $table->string('remarks')->nullable();
            $table->smallInteger('check_1')->comment('1-OK, 2-NG, 3-Conversion, 4-NA');
            $table->smallInteger('check_2')->comment('1-OK, 2-NG, 3-Conversion, 4-NA');
            $table->smallInteger('check_3')->comment('1-OK, 2-NG, 3-Conversion, 4-NA');
            $table->string('value_1')->nullable();
            $table->smallInteger('judgment_1')->comment('1-Yes, 2-NG, 3-Conversion, 4-NA');
            $table->string('value_2')->nullable();
            $table->smallInteger('judgment_2')->comment('1-Yes, 2-NG, 3-Conversion, 4-NA');
            $table->string('value_3')->nullable();
            $table->smallInteger('judgment_3')->comment('1-Yes, 2-NG, 3-Conversion, 4-NA');
            $table->string('value_4')->nullable();
            $table->string('value_5')->nullable();
            $table->smallInteger('judgment_5')->comment('1-Yes, 2-NG, 3-Conversion, 4-NA');
            $table->smallInteger('judgment_6')->comment('1-Yes, 2-NG, 3-Conversion, 4-NA');
            $table->string('value_6')->nullable();
            $table->smallInteger('logdel')->comment('0-active, 1-inactive');


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
        Schema::dropIfExists('assembly_pre_prods');
    }
}
