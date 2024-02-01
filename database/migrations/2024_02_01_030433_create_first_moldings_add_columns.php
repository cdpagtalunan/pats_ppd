<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstMoldingsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('first_moldings', function (Blueprint $table) {
            $table->string('production_lot_extension')->nullable()->after('production_lot');
            $table->string('machine_no')->after('status');
            $table->float('target_shots')->nullable()->default(0)->after('machine_no');
            $table->float('adjustment_shots')->nullable()->default(0)->after('target_shots');
            $table->string('pmi_po_no')->nullable()->after('adjustment_shots');
            $table->string('po_no')->nullable()->after('pmi_po_no');
            $table->float('po_qty')->nullable()->default(0)->after('po_no');
            $table->float('required_output')->nullable()->default(0)->after('po_qty');
            $table->string('item_code')->nullable()->after('required_output');
            $table->string('item_name')->nullable()->after('item_code');
            $table->float('qc_samples')->nullable()->default(0)->after('item_name');
            $table->float('prod_samples')->nullable()->default(0)->after('qc_samples');
            $table->float('ng_count')->nullable()->default(0)->after('prod_samples');
            $table->float('total_machine_output')->nullable()->default(0)->after('ng_count');
            $table->float('shipment_output')->nullable()->default(0)->after('total_machine_output');
            $table->float('material_yield')->nullable()->default(0)->after('shipment_output');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_moldings_add_columns');
    }
}
