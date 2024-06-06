<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMimfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mimfs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pps_po_rcvd_id')->comment = 'tbl_POReceived ID -> ABANG LANG WAG KANG MAGALIT';
            $table->unsignedBigInteger('pps_whse_id')->comment = 'tbl_Warehouse ID -> ABANG LANG WAG KANG MAGALIT';
            $table->unsignedBigInteger('pps_dieset_id')->comment = 'tbl_dieset ID -> ABANG LANG WAG KANG MAGALIT';
            $table->unsignedBigInteger('ppd_matrix_id');
            $table->string('control_no')->nullable();
            $table->string('date_issuance')->nullable();
            $table->string('pmi_po_no')->nullable();
            $table->string('prodn_qty')->nullable();
            $table->string('device_code')->nullable();
            $table->string('device_name')->nullable();
            $table->string('material_code')->nullable();
            $table->string('material_type')->nullable();
            $table->string('qty_invt')->nullable();
            $table->string('request_pins_pcs')->nullable()->comment = 'For 2nd Stamping';
            $table->string('needed_kgs')->nullable();
            $table->string('virgin_material')->nullable();
            $table->string('recycled')->nullable();
            $table->string('prodn')->nullable();
            $table->string('delivery')->nullable();
            $table->string('remarks')->nullable();
            $table->string('scan_by')->nullable()->comment = 'scan id to save';
            $table->string('created_by')->nullable()->comment = 'user login';
            $table->string('updated_by')->nullable()->comment = 'user login';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
            $table->unsignedTinyInteger('status')->default(0)->comment = '1-Stamping,2-Molding';
            $table->unsignedTinyInteger('category')->default(0)->comment = '1-First,2-Second';
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
        Schema::dropIfExists('mimfs');
    }
}
