<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('mt_number', 7);
            $table->unsignedInteger('equipment_id');
            $table->text('description')->nullable();
            $table->enum('status', ['not started', 'in progress', 'waiting for part', 'waiting for quotation', 'completed'])->default('not started');
            $table->unsignedInteger('submitted_by')->nullable();
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
        Schema::dropIfExists('maintenance_reports');
    }
}
