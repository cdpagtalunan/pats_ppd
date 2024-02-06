<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingDetailsMoldingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packing_details_moldings', function (Blueprint $table) {
            $table->id();
            $table->integer('oqc_id');
            $table->string('endorsedby')->nullable();
            $table->string('date_endorsed')->nullable();
            $table->string('receivedby')->nullable();
            $table->string('date_received')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0-Endoresed to Molding, 1-Received';
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
        Schema::dropIfExists('packing_details_moldings');
    }

}
