<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingProductionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_production_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('stamping_production_id')->nullable();
            // $table->integer('status')->nullable();
            // $table->integer('ctrl_counter')->nullable();
            // $table->string('po_num')->nullable();
            // $table->integer('po_qty')->nullable();
            // $table->string('part_code')->nullable();
            // $table->string('material_name')->nullable();
            // $table->string('material_lot_no')->nullable();
            // $table->string('drawing_no')->nullable();
            // $table->string('drawing_rev')->nullable();
            // $table->string('operator')->nullable();
            // $table->string('shift')->nullable();
            // $table->date('prod_date')->nullable();
            // $table->integer('cut_off_point')->nullable();
            // $table->integer('no_of_cuts')->nullable();
            // $table->string('prod_lot_no')->nullable();
            // $table->integer('input_coil_weight')->nullable();
            // $table->integer('ppc_target_output')->nullable();
            // $table->integer('planned_loss')->nullable();
            $table->integer('set_up_pins')->nullable();
            $table->integer('adj_pins')->nullable();
            $table->integer('qc_samp')->nullable();
            $table->integer('ng_count')->nullable();
            $table->integer('prod_samp')->nullable();
            $table->longText('remarks')->nullable();
            // $table->integer('total_mach_output')->nullable();
            // $table->integer('ship_output')->nullable();
            // $table->string('mat_yield')->nullable();
            // $table->integer('print_count')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('stamping_production_histories');
    }
}
