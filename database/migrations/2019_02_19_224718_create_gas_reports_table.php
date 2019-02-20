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
            $table->float('value', 15, 2);
            $table->float('consumption', 15, 2);
            $table->float('price', 15, 2);
            $table->float('month_to_date', 15, 2);
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
