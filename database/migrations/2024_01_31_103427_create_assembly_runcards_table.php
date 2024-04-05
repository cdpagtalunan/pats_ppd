<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyRuncardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_runcards', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('device_name')->nullable();
            $table->string('part_code')->nullable();
            $table->string('material_name')->nullable();
            $table->string('po_number')->nullable();
            $table->string('po_quantity')->nullable();
            $table->string('required_output')->nullable();
            $table->string('runcard_no')->nullable();
            $table->string('shipment_output')->nullable();
            $table->string('p_zero_two_prod_lot')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->tinyInteger('status')->default(0)->comment ='';
            $table->softDeletes()->comment ='0-Active, 1-Deleted';
            $table->timestamps();

            // Foreign Key
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assembly_runcards');
    }
}
