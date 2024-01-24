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
    {
        Schema::create('first_molding_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('first_molding_id')->comment = 'Id from first_moldings(table)';
            $table->string('station');
            $table->string('date');
            $table->string('name');
            $table->integer('input');
            $table->integer('ng_qty');
            $table->integer('output');
            $table->integer('remarks');
            $table->tinyInteger('status')->comment ='';
            $table->tinyInteger('logdel')->comment ='0-Active, 1-Deleted';
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
        Schema::dropIfExists('first_molding_details');
    }
}
