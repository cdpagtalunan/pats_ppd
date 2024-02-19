<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstMoldingMaterialListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_molding_material_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('first_molding_id')->references('id')->on('first_moldings')->comment ='Reference to first_molding_stations id(table)';
            $table->string('virgin_material')->nullable();
            $table->string('recycle_material')->nullable();
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
        Schema::dropIfExists('first_molding_material_lists');
    }
}
