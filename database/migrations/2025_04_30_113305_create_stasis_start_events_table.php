<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStasisStartEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('stasis_start_events', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->timestamp('timestamp');
            $table->string('asterisk_id');
            $table->string('application');

            $table->json('args')->nullable();

            $table->string('channel_id');
            $table->string('channel_name');
            $table->string('channel_state');
            $table->string('channel_protocol_id')->nullable();

            $table->string('caller_name')->nullable();
            $table->string('caller_number');

            $table->string('connected_name')->nullable();
            $table->string('connected_number')->nullable();

            $table->string('accountcode')->nullable();

            $table->string('dialplan_context');
            $table->string('dialplan_exten');
            $table->unsignedInteger('dialplan_priority');
            $table->string('dialplan_app_name');
            $table->text('dialplan_app_data')->nullable();

            $table->timestamp('channel_creationtime')->nullable();
            $table->string('channel_language')->default('en');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stasis_start_events');
    }
}