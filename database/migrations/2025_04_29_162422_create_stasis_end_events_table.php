<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStasisEndEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('stasis_end_events', function (Blueprint $table) {
        $table->id();
        $table->string('type');
        $table->timestamp('timestamp');
        $table->string('asterisk_id');
        $table->string('application');

        // Channel details
        $table->string('channel_id');
        $table->string('channel_name');
        $table->string('channel_state');
        $table->string('channel_protocol_id');
        $table->string('caller_name')->nullable();
        $table->string('caller_number')->nullable();
        $table->string('connected_name')->nullable();
        $table->string('connected_number')->nullable();
        $table->string('accountcode')->nullable();
        $table->string('dialplan_context');
        $table->string('dialplan_exten');
        $table->integer('dialplan_priority');
        $table->string('dialplan_app_name');
        $table->text('dialplan_app_data')->nullable();
        $table->timestamp('channel_creationtime')->nullable();;
        $table->string('channel_language')->nullable();

        $table->timestamps();
    });
}
}
