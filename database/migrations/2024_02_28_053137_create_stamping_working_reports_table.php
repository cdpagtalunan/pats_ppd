<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingWorkingReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_working_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('control_number')->nullable();
            $table->string('machine_number')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
            $table->string('work_details')->nullable();
            $table->string('sequence_number')->nullable();
            $table->foreignId('created_by')->references('id')->on('users')->comment ='Id from users(table)';
            $table->foreignId('last_updated_by')->references('id')->on('users')->comment ='Id from users(table)';
            $table->softDeletes()->comment ='0-Active, 1-Deleted';
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
        Schema::dropIfExists('stamping_working_reports');
    }
}
