<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricityReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electricity_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->float('lwbp', 11, 2);
            $table->float('lwbp_total', 15, 2);
            $table->float('lwbp_price', 15, 2);
            $table->float('wbp', 11, 2);
            $table->float('wbp_total', 15, 2);
            $table->float('wbp_price', 15, 2);
            $table->float('cost_total', 15, 2);
            $table->integer('occupancy');
            $table->float('electricity_per_room', 11, 2);
            $table->float('month_to_date_cost', 15, 2);
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
        Schema::dropIfExists('electricity_reports');
    }
}
