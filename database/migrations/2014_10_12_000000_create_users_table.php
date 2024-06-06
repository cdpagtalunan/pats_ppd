<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('username');
            $table->string('email')->nullable();
            $table->string('employee_id');
            $table->string('password');
            $table->tinyInteger('position')->default(0)->comment = '0-ISS,1-Prod Supervisor,2-QC Supervisor,3-Material Handler,4-Operator,5-Inspector';
            $table->tinyInteger('section')->default(0)->comment = '0-N/A, 1-Stamping,2-molding';
            $table->string('is_password_changed');
            $table->unsignedTinyInteger('status')->default(1)->comment = '1-active,2-inactive';
            $table->string('oqc_stamp')->nullable();
            $table->integer('update_version');
            $table->unsignedBigInteger('user_level_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_level_id')->references('id')->on('user_levels');
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
        Schema::dropIfExists('users');
    }
}
