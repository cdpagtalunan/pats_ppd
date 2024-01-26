<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecMoldingRuncardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sec_molding_runcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('first_molding_id')->comment = "Id from first_moldings(table)";
            $table->string('device_name')->nullable();
            $table->string('parts_code')->nullable();
            $table->string('po_number')->nullable();
            $table->string('po_quantity')->nullable();
            $table->string('machine_number')->nullable();
            $table->string('machine_lot_number')->nullable();
            $table->string('machine_name')->nullable();
            $table->string('drawing_number')->nullable();
            $table->string('revision_number')->nullable();
            $table->string('production_lot')->nullable();
            $table->string('production_lot')->nullable();
            $table->string('production_lot')->nullable();
            $table->string('production_lot')->nullable();
            $table->tinyInteger('status')->comment ='';
            $table->softDeletes()->comment ='0-Active, 1-Deleted';
            $table->timestamps();
        });
  