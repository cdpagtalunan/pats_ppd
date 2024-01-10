<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingIpqcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_ipqcs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fs_productions_id')->comment = 'id from first_stamping_productions table';
            $table->string('po_number')->nullable();
            $table->string('part_code')->nullable();
            $table->string('material_name')->nullable();
            $table->unsignedBigInteger('ipqc_inspector_name')->nullable();
            $table->string('document_no')->nullable();
            $table->string('measdata_attachment')->nullable();
            $table->string('ilqcm_attachment')->nullable();
            $table->tinyInteger('status')->default(0)->comment = '0-Pending, 1-Done';
            $table->tinyInteger('logdel')->default(0)->comment = '0-Active, 1-Deleted';
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('stamping_ipqcs');
    }
}
