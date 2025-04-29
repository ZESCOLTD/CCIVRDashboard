<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class StasisEndEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'timestamp',
        'asterisk_id',
        'application',
        'channel_id',
        'channel_name',
        'channel_state',
        'channel_protocol_id',
        'caller_name',
        'caller_number',
        'connected_name',
        'connected_number',
        'accountcode',
        'dialplan_context',
        'dialplan_exten',
        'dialplan_priority',
        'dialplan_app_name',
        'dialplan_app_data',
        'channel_creationtime',
        'channel_language',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'channel_creationtime' => 'datetime',
    ];
    // Extract caller channel_id from dialplan_app_data of the callee's StasisEnd event
    public function getCallerChannelId()
    {
        $appData = $this->dialplan_app_data;
        preg_match('/channel(\d+\.\d+)/', $appData, $matches);
        return $matches[1] ?? null;
    }

    // Check if the call is abandoned (i.e., it never reached the callee)
    public function isAbandoned()
    {
        return empty($this->connected_number) || $this->channel_state !== 'Up';
    }

    // Check if the call is missed (i.e., connected but incomplete)
    public function isMissed()
    {
        return !empty($this->connected_number) && $this->channel_state !== 'Up';
    }

    // Check if the call is answered (i.e., callee picked up the call)
    public function isAnswered()
    {
        return !empty($this->connected_number) && $this->channel_state === 'Up';
    }

    // Group events by caller's channel_id to pair StasisEnd events for the same call
    public static function groupByCallerChannel()
    {
        $events = self::all();
    $calls = [];

    foreach ($events as $event) {
        // Check for the "hello" application name
        if ($event->dialplan_app_name === 'hello') {
            // Debug: Output the event to ensure it's being captured
            Log::debug('Processing StasisEnd Event: ', ['event' => $event]);

            // Extract caller channel_id from dialplan_app_data
            $callerChannelId = $event->getCallerChannelId();
            if ($callerChannelId) {
                // Debug: Check if the caller channel_id is being extracted correctly
                ('Caller Channel ID extracted: ' . $callerChannelId);

                // Search for matching callee event by channel_id
                $calleeEvent = $events->firstWhere('channel_id', $callerChannelId);

                // If matching callee event is found
                if ($calleeEvent) {
                    // Debug: Output the matched callee event
                    Log::debug('Matched callee event: ', ['callee' => $calleeEvent]);

                    // Group the caller and callee together
                    $calls[] = [
                        'caller' => $event,
                        'callee' => $calleeEvent,
                    ];
                }
            }
        }
    }


        return $calls;
    }
}
