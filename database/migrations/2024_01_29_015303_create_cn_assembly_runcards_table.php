<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnAssemblyRuncardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cn_assembly_runcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sec_molding_runcard_id')->comment ='Id from sec_molding_runcards(table)';
            $table->string('device_name')->nullable();
            $table->string('parts_code')->nullable();
            $table->string('po_number')->nullable();
            $table->string('po_quantity')->nullable();
            $table->string('runcard_no')->nullable();

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
        Schema::dropIfExists('cn_assembly_runcards');
    }
}
