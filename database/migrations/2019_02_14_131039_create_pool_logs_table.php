<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoolLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->float('cl');
            $table->float('ph');
            $table->text('remark')->nullable();
            $table->enum('method', ['manual', 'digital']);
            $table->enum('compound', ['neo-chlorine 90', 'china chlorine', 'hydrogne peroxide', 'hcl', 'soda ash', 'pac'])->nullable();
            $table->string('value')->nullable();
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('pool_logs');
    }
}
