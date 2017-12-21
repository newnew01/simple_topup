<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopupLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('orderid');
            $table->string('branch_name');
            $table->string('network');
            $table->string('number');
            $table->integer('cash');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topup_logs');
    }
}
