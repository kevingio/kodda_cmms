<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('equipment_model_id');
            $table->string('manufacturer')->nullable();
            $table->string('description')->nullable();
            $table->string('serial_number', 30)->unique();
            $table->unsignedInteger('location_id');
            $table->integer('maintenance_period')->nullable();
            $table->string('contact')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
