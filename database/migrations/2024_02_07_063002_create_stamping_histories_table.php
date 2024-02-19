<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamping_histories', function (Blueprint $table) {
            $table->id();
            $table->string('part_name')->nullable();
            $table->string('die_code_no')->nullable();
            $table->string('date')->nullable();
            $table->string('total_shot')->nullable();
            $table->string('operator')->nullable();
            $table->string('machine_no')->nullable();
            $table->string('die_height')->nullable();
            $table->string('revolution_no')->nullable();
            $table->string('rev_no')->nullable();
            $table->string('neraiti')->nullable()->comment = '1-Yes, 2-None';
            $table->string('remarks')->nullable();
            $table->string('scan_by')->nullable()->comment = 'scan id to save';
            $table->string('created_by')->nullable()->comment = 'user login';
            $table->string('updated_by')->nullable()->comment = 'user login';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-show,1-hide';
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
        Schema::dropIfExists('stamping_histories');
    }
}
