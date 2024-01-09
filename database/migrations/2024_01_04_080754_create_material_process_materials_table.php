<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialProcessMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_process_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mat_proc_id')->comment = "material_processes";
            $table->string('material_id')->comment = "db_pps tbl_Warehouse";
            $table->string('material_type')->comment = "db_pps tbl_Warehouse";
            $table->string('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('material_process_materials');
    }
}
