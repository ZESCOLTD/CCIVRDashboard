<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColumnsToCallSessionToAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('call_session_to_agent', function (Blueprint $table) {
            $table->string('status')->nullable();
            $table->string('time_from')->nullable();
            $table->string('time_to')->nullable();
            $table->string('session_name')->nullable();
            $table->string('username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_session_to_agent', function (Blueprint $table) {
            $table->dropColumn(['status', 'time_from', 'time_to', 'session_name', 'username']);
        });
    }
}
