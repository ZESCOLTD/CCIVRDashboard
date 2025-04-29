<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDialEventLogsTable extends Migration
{
    public function up()
    {
        Schema::create('dial_event_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type');
            $table->timestamp('event_timestamp');
            $table->string('dialstatus')->nullable();
            $table->string('forward')->nullable();
            $table->string('dialstring');
            $table->string('asterisk_id');
            $table->string('application');

            // Peer details
            $table->string('peer_id');
            $table->string('peer_name');
            $table->string('peer_state');
            $table->string('peer_protocol_id');
            $table->string('peer_accountcode')->nullable();
            $table->timestamp('peer_creationtime')->nullable();
            $table->string('peer_language');

            // Caller info
            $table->string('caller_name')->nullable();
            $table->string('caller_number');

            // Connected info
            $table->string('connected_name')->nullable();
            $table->string('connected_number');

            // Dialplan
            $table->string('dialplan_context');
            $table->string('dialplan_exten');
            $table->integer('dialplan_priority');
            $table->string('dialplan_app_name');
            $table->string('dialplan_app_data');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dial_event_logs');
    }
}
