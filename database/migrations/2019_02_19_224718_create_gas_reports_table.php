<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGasReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gas_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('gas');
            $table->bigInteger('gas_comsumption');
            $table->bigInteger('gas_price');
            $table->bigInteger('gas_month_to_date');
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
        Schema::dropIfExists('gas_reports');
    }
}
