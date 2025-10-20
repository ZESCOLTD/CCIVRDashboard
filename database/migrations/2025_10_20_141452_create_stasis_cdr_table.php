<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStasisCdrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stasis_cdr', function (Blueprint $table) {
            $table->id();

            // --- CLOSURE KEYS (Traceability back to source events) ---
            $table->unsignedBigInteger('stasis_start_event_id')->comment('PK ID of the inbound callers StasisStart event.');
            $table->unsignedBigInteger('stasis_end_event_id')->nullable()->comment('PK ID of the final StasisEnd event (caller or callee hangup).');

            // --- Core Identifiers and Call Legs (Channel IDs) ---
            $table->string('caller_channel_id')->unique()->comment('The channel_id of the inbound (caller) leg.');
            $table->string('callee_channel_id')->nullable()->comment('The channel_id of the outbound (agent) leg.');
            $table->string('caller_number')->index();

            // --- Call Timestamps (The 'closure' of the events) ---
            $table->timestamp('start_time')->index()->comment('Timestamp of the StasisStart (Ring) event.');
            $table->timestamp('answer_time')->nullable()->comment('Timestamp of the callee StasisStart (Up) event.');
            $table->timestamp('end_time')->nullable()->index()->comment('Timestamp of the StasisEnd event.');

            // --- Agent Information (From the callee leg) ---
            $table->string('agent_name')->nullable()->comment('Name of the answering agent.');
            $table->string('agent_extension')->nullable()->comment('Extension of the answering agent.');

            // --- Metric Flags and Classifications ---
            $table->boolean('is_answered')->default(false)->index();
            $table->boolean('is_abandoned')->default(false)->index()->comment('True if answered=false AND duration > threshold.');
            $table->boolean('is_short_miss')->default(false)->index()->comment('True if answered=false AND is_abandoned=false.');

            // --- Calculated Durations ---
            $table->unsignedInteger('ring_duration_seconds')->nullable()->comment('Total time the caller was on the line before answer or hangup.');
            $table->unsignedInteger('time_to_answer_seconds')->nullable()->comment('Time between start_time and answer_time (ASA).');
            $table->unsignedInteger('talk_time_seconds')->nullable()->comment('Time between answer_time and end_time (AHT).');

            $table->timestamps();

            // --- Foreign Key Constraints ---
            $table->foreign('stasis_start_event_id')->references('id')->on('stasis_start_events')->onDelete('cascade');
            $table->foreign('stasis_end_event_id')->references('id')->on('stasis_end_events')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdr');
    }
}
