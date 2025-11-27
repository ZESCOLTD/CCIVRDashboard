<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StasisStartEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'timestamp',
        'asterisk_id',
        'application',
        'args',
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
        'args' => 'array',
    ];

    public function stasisEnd()
    {
        return $this->belongsTo(StasisEndEvent::class, 'channel_id', 'channel_id');
            // ->where('type', 'StasisEnd');
    }

    public function getRelatedStasisStartAttribute()
    {
        // Get the related channel ID from the 'args' array (at index 2)
        $relatedChannelId = $this->args[2] ?? null;

        // If there is no ID, we can't find a related model
        if (!$relatedChannelId) {
            return null;
        }

        // Find and return the StasisStartEvent where the channel_id matches.
        // We use first() because we expect only one related record.
        return StasisStartEvent::where('channel_id', $relatedChannelId)->first();
    }
    public function dialEvents()
    {
        return $this->hasMany(DialEventLog::class, 'peer_name', 'channel_name');
            // ->where('type', 'StasisEnd');
    }

    /**
     * Accessor to retrieve the recording file name from the 'args' array.
     * Based on the configuration, the file name is the fifth element (index 4).
     *
     * @return string|null
     */
    public function getRecordingFileNameAttribute(): ?string
    {
        // The fifth item in a zero-indexed array is at index 4.
        return $this->args[4] ?? null;
    }


}