<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdr', function (Blueprint $table) {
            $table->id();

            $table->string('accountcode')->nullable();
            $table->string('src')->nullable();
            $table->string('dst')->nullable();
            $table->string('dcontext')->nullable();
            $table->string('clid')->nullable();
            $table->string('channel')->nullable();
            $table->string('dstchannel')->nullable();
            $table->string('lastapp')->nullable();
            $table->string('lastdata')->nullable();
            $table->string('calldate')->nullable();
            $table->string('answerdate')->nullable();
            $table->string('hangupdate')->nullable();
            $table->string('duration')->nullable();
            $table->string('billsec')->nullable();
            $table->string('disposition')->nullable();
            $table->string('amaflags')->nullable();
            $table->string('uniqueid')->nullable();
            $table->string('userfield')->nullable();

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
        Schema::dropIfExists('cdr');
    }
}
