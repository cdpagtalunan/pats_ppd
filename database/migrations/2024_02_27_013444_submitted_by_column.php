<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubmittedByColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assembly_fvis', function (Blueprint $table) {
            $table->string('submitted_by')->nullable()->after('g_drawing_no');
            $table->string('submitted_at')->nullable()->after('submitted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assembly_fvis', function (Blueprint $table) {
            //
        });
    }
}
