<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialDryingColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sec_molding_runcards', function (Blueprint $table) {
            $table->string('part_name')->nullable();
            $table->string('lubricant')->nullable();
            $table->string('applied_date')->nullable();
            $table->string('drying_time_start')->nullable();
            $table->string('drying_time_end')->nullable();
            $table->foreignId('operator_id')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sec_molding_runcards', function (Blueprint $table) {
            //
        });
    }
}
