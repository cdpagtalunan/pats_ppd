<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyFvisRuncardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_fvis_runcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assembly_fvis_id')->references('id')->on('assembly_fvis');
            $table->unsignedBigInteger('prod_runcard_id');
            $table->string('date');
            $table->bigInteger('input')->nullable();
            $table->bigInteger('output')->nullable();
            $table->bigInteger('ng_qty')->nullable();
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('assembly_fvis_runcards');
    }
}
