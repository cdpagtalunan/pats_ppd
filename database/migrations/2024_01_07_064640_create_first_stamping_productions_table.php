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
        Schema::create('stamping_productions', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0)->comment = "0-For IQC, 1-For Mass Prod, 2-Done";
            $table->integer('stamping_cat')->comment = "1-1st Stamping, 2-2nd Stamping";
            $table->integer('ctrl_counter');
            $table->string('po_num');
            $table->integer('po_qty');
            $table->string('part_code');
            $table->string('material_name');
            $table->string('material_lot_no');
            $table->string('material_lot_qty');
            $table->string('drawing_no');
            $table->string('drawing_rev');
            $table->string('operator')->comment = "id from users";
            $table->string('shift');
            $table->date('prod_date')->nullable();
            $table->integer('cut_off_point')->nullable()->comment = "0-without, 1-with";
            $table->integer('no_of_cuts')->nullable();
            $table->string('prod_lot_no');
            $table->integer('input_coil_weight')->nullable();
            $table->integer('ppc_target_output')->nullable();
            $table->integer('planned_loss');
            $table->integer('set_up_pins');
            $table->integer('adj_pins');
            $table->integer('qc_samp');
            $table->integer('ng_count')->default(0)->comment = "this will have value if ng on ipqc";
            $table->integer('prod_samp')->nullable();
            $table->integer('total_mach_output')->nullable();
            $table->integer('ship_output')->nullable();
            $table->string('mat_yield')->nullable();
            $table->integer('print_count')->default(0);

            $table->integer('trays')->nullable()->comment = "0-without, 1-with (second_stamping)";
            $table->integer('no_of_trays')->nullable()->comment = "(second_stamping)";
            $table->integer('input_pins')->default(0)->comment = "(second_stamping)";
            $table->integer('actual_qty')->default(0)->comment = "(second_stamping)";
            $table->integer('target_output')->default(0)->comment = "(second_stamping)";

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
        Schema::dropIfExists('stamping_productions');
    }
}
