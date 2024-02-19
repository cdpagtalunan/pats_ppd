<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationPortDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination_port_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('destination_port')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0-Active, 1-Deactivated';
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
        Schema::dropIfExists('destination_port_details');
    }
}
