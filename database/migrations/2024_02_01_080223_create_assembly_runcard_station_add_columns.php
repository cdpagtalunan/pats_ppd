<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblyRuncardStationAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assembly_runcard_stations', function (Blueprint $table) {
            $table->string('station_yield')->nullable()->after('output_quantity')->comment ='yield per station';
            $table->string('mode_of_defect')->nullable()->after('station_yield')->comment ='from tbl mode_of_defect';
            $table->string('defect_qty')->nullable()->after('mode_of_defect');
            $table->string('doc_no_wi')->nullable()->after('defect_qty')->comment ='for visual insp';
            $table->string('doc_no_r_drawing')->nullable()->after('doc_no_wi')->comment ='for visual insp';
            $table->string('doc_no_a_drawing')->nullable()->after('doc_no_r_drawing')->comment ='for visual insp';
            $table->string('doc_no_g_drawing')->nullable()->after('doc_no_a_drawing')->comment ='for visual insp';
            // $table->string('date_code')->nullable()->after('doc_no_g_drawing')->comment ='for visual insp';
            // $table->string('bundle_qty')->nullable()->after('date_code')->comment ='for visual insp';
            $table->string('ml_per_shot')->nullable()->after('bundle_qty')->comment ='for lubricant coating';
            $table->string('total_lubricant_usage')->nullable()->after('ml_per_shot')->comment ='for lubricant coating';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assembly_runcard_station_add_columns');
    }
}
