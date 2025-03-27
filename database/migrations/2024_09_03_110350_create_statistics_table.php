<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('receivedCalls');
            $table->integer('missedCalls');
            $table->integer('answereCalls');
            $table->integer('agentTerminatedCalls');
            $table->integer('callerTerminatedCalls');
            $table->integer('dialedCalls');
            $table->integer('unknownStateCallsTried');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
