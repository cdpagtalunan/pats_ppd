<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstStampingProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_stamping_productions', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->string('po_num');
            $table->integer('po_qty');
            $table->string('part_code');
            $table->string('material_name');
            $table->string('material_lot_no');
            $table->string('drawing_no');
            $table->string('drawing_rev');
            $table->string('shift');
            $table->date('prod_date');
            $table->string('prod_lot_no');
            $table->integer('input_coil_weight');
            $table->integer('ppc_target_output');
            $table->integer('planned_loss');
            $table->integer('set_up_pins');
            $table->integer('adj_pins');
            $table->integer('qc_samp');
            $table->integer('prod_samp');
            $table->integer('total_mach_output');
            $table->integer('ship_output');
            $table->string('mat_yield');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_stamping_productions');
    }
}
