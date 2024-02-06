<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreliminaryPackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preliminary_packings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('oqc_id');
            $table->string('po_no');
            $table->string('validated_by');
            $table->string('validated_date');
            $table->tinyInteger('status')->comment ='0- OQC PASSED, 1-FOR PACKING LIST';
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
        Schema::dropIfExists('preliminary_packings');
    }
}
