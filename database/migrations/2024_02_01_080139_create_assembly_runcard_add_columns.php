<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyRuncardAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assembly_runcards', function (Blueprint $table) {
            $table->unsignedBigInteger('p_zero_two_device_id')->after('runcard_no');
            $table->string('s_zero_seven_prod_lot')->nullable()->after('p_zero_two_device_id');
            $table->unsignedBigInteger('s_zero_seven_device_id')->after('s_zero_seven_prod_lot');
            $table->string('s_zero_two_prod_lot')->nullable()->after('s_zero_seven_device_id');
            $table->unsignedBigInteger('s_zero_two_device_id')->after('s_zero_two_prod_lot');
            $table->string('total_assembly_yield')->nullable()->after('s_zero_two_device_id');
            $table->string('average_overall_yield')->nullable()->after('total_assembly_yield')->comment ='average yield of 1st, 2nd molding & assembly';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assembly_runcard_add_columns');
    }
}
