<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wo_number', 7);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('submitted_by')->nullable();
            $table->text('task');
            $table->enum('status', ['not started', 'in progress', 'waiting for part', 'waiting for quotation', 'completed'])->default('not started');
            $table->unsignedInteger('location_id');
            $table->datetime('due_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->string('comment')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('work_orders');
    }
}
