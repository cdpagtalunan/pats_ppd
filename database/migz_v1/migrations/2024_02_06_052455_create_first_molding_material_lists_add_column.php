<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstMoldingMaterialListsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('first_molding_material_lists', function (Blueprint $table) {
            $table->string('virgin_qty')->nullable()->after('virgin_material');
            $table->string('recycle_qty')->nullable()->after('recycle_material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_molding_material_lists_add_column');
    }
}
