<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyFvisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_fvis', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status')->default(0);
            $table->string('po_no');
            $table->string('device_name');
            $table->string('device_code');
            $table->Integer('po_qty');
            $table->string('lot_no');
            $table->string('remarks');
            $table->string('assembly_line');
            $table->string('a_drawing_no');
            $table->string('a_drawing_rev');
            $table->string('g_drawing_rev');
            $table->string('g_drawing_no');
            $table->foreignId('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('assembly_fvis');
    }
}
