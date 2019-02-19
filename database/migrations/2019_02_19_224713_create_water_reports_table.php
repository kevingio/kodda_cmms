<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pdam');
            $table->bigInteger('pdam_comsumption');
            $table->bigInteger('pdam_price');
            $table->bigInteger('pdam_month_to_date');
            $table->bigInteger('deep_well');
            $table->bigInteger('deep_well_comsumption');
            $table->bigInteger('deep_well_total');
            $table->bigInteger('deep_well_month_to_date');
            $table->bigInteger('occupancy');
            $table->float('water_per_room', 15, 2);
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
        Schema::dropIfExists('water_reports');
    }
}
