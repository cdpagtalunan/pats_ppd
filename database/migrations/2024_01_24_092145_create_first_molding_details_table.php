<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstMoldingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { //31
        Schema::create('first_molding_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('first_molding_id')->unsigned()->comment = 'Id from first_moldings(table)';
            $table->string('station')->nullable();
            $table->string('date')->nullable();
            $table->string('operator_name')->nullable();
            $table->integer('input')->nullable();
            $table->integer('ng_qty')->nullable();
            $table->integer('output')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment ='';
            $table->softDeletes()->nullable();
            $table->timestamps();
            $table->foreign('first_molding_id')->references('id')->on('first_moldings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_molding_details');
    }
}
