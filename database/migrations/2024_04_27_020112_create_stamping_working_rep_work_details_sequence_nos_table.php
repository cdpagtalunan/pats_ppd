<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingWorkingRepWorkDetailsSequenceNosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_working_rep_work_details_sequence_nos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sequence_number')->nullable();
            $table->string('ct_name')->nullable();
            $table->string('code_number')->nullable();
            $table->string('spm')->nullable();
            $table->string('po_number')->nullable();
            $table->string('shipment_output')->nullable()->comment = "Produced Qty";
            $table->string('machine_output')->nullable()->comment = "Produced Qty";
            $table->string('in_charge')->nullable();
            
            $table->foreignId('stamping_working_report_id')->references('id')->on('stamping_working_reports')->index('sequence_nos_stamping_working_report_id_foreign')->comment ='Id from stamping_working_reports(table)';
            $table->foreignId('stamping_working_report_work_details_id')->references('id')->on('stamping_working_report_work_details')->index('stamping_working_report_work_details_id_foreign')->comment ='Id from stamping_working_report_work_details(table)';
            $table->foreignId('created_by')->references('id')->on('users')->index('sequence_nos_created_by_foreign')->comment ='Id from users(table)';
            $table->foreignId('last_updated_by')->nullable()->references('id')->on('users')->index('sequence_nos_last_updated_by_foreign')->comment ='Id from users(table)';
            $table->softDeletes()->comment ='If NOT NULL means deleted';
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
        Schema::dropIfExists('stamping_working_rep_work_details_sequence_nos');
    }
}
