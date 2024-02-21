<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecMoldingRuncardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_molding_runcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_name')->nullable();
            $table->string('parts_code')->nullable();
            $table->string('pmi_po_number')->nullable();
            $table->string('po_number')->nullable();
            $table->string('po_quantity')->nullable();
            $table->string('required_output')->nullable();
            $table->string('total_yield')->nullable();
            $table->string('machine_number')->nullable();
            $table->string('material_lot_number')->nullable();
            $table->string('material_name')->nullable();
            $table->string('drawing_number')->nullable();
            $table->string('revision_number')->nullable();
            $table->string('production_lot')->nullable();
            $table->string('lot_number_eight')->nullable();
            $table->integer('lot_number_eight_first_molding_id')->comment = "Id from first_moldings(table)";
            $table->string('lot_number_nine')->nullable();
            $table->integer('lot_number_nine_first_molding_id')->comment = "Id from first_moldings(table)";
            $table->string('lot_number_ten')->nullable();
            $table->integer('lot_number_ten_first_molding_id')->comment = "Id from first_moldings(table)";
            $table->string('contact_name_lot_number_one')->nullable();
            $table->string('contact_name_lot_number_second')->nullable();
            $table->string('me_name_lot_number_one')->nullable();
            $table->string('me_name_lot_number_second')->nullable();

            $table->integer('target_shots')->nullable();
            $table->integer('adjustment_shots')->nullable();
            $table->integer('qc_samples')->nullable();
            $table->integer('prod_samples')->nullable();
            $table->integer('ng_count')->nullable();
            $table->integer('total_machine_output')->nullable();
            $table->integer('shipment_output')->nullable();
            $table->float('material_yield')->nullable();

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
        Schema::dropIfExists('sec_molding_runcards');
    }
}
