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
            $table->float('pdam', 15, 2);
            $table->float('pdam_consumption', 15, 2);
            $table->float('pdam_cost', 15, 2);
            $table->float('pdam_month_to_date', 15, 2);
            $table->float('deep_well', 15, 2);
            $table->float('deep_well_consumption', 15, 2);
            $table->float('deep_well_cost', 15, 2);
            $table->float('deep_well_month_to_date', 15, 2);
            $table->integer('occupancy');
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
