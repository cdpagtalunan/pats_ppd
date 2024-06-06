<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingWorkingReportWorkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_working_report_work_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->string('total_minutes')->nullable();
            $table->string('work_details')->nullable();
            
            $table->foreignId('stamping_working_report_id')->references('id')->on('stamping_working_reports')->index('stamping_working_report_id')->comment ='Id from stamping_working_reports(table)';
            $table->foreignId('created_by')->references('id')->on('users')->comment ='Id from users(table)';
            $table->foreignId('last_updated_by')->nullable()->references('id')->on('users')->comment ='Id from users(table)';
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
        Schema::dropIfExists('stamping_working_report_work_details');
    }
}
