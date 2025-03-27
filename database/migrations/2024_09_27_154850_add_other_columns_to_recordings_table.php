<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherColumnsToRecordingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recordings', function (Blueprint $table) {
            $table->string('src')->nullable();
            $table->string('dst')->nullable();
            $table->string('clid')->nullable();
            $table->timestamp('calldate')->nullable();
            $table->timestamp('answerdate')->nullable();
            $table->timestamp('hangupdate')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('billsec')->nullable();
            $table->string('disposition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recordings', function (Blueprint $table) {
            $table->dropColumn([
                'src',
                'dst',
                'clid',
                'calldate',
                'answerdate',
                'hangupdate',
                'duration',
                'billsec',
                'disposition'
            ]);
        });
    }
}
