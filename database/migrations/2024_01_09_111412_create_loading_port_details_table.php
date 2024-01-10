<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadingPortDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loading_port_details', function (Blueprint $table) {
            $table->id();
            $table->string('loading_port')->nullable();
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
        Schema::dropIfExists('loading_port_details');
    }
}
