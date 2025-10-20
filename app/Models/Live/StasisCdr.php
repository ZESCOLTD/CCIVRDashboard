<?php

namespace App\Models\Live;

use App\Models\Live\StasisEndEvent;
use App\Models\Live\StasisStartEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $stasis_start_event_id
 * @property int|null $stasis_end_event_id
 * @property string $caller_channel_id
 * @property string|null $callee_channel_id
 * @property string $caller_number
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon|null $answer_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property string|null $agent_name
 * @property string|null $agent_extension
 * @property bool $is_answered
 * @property bool $is_abandoned
 * @property bool $is_short_miss
 * @property int|null $ring_duration_seconds
 * @property int|null $time_to_answer_seconds
 * @property int|null $talk_time_seconds
 */
class StasisCDR extends Model
{
    use HasFactory;

    protected $table = 'stasis_cdr';

    // Since this table is populated by a controlled background job/seeder, we can unguard all fields.
    protected $guarded = [];

    protected $casts = [
        // Timestamps
        'start_time' => 'datetime',
        'answer_time' => 'datetime',
        'end_time' => 'datetime',

        // Boolean Flags
        'is_answered' => 'boolean',
        'is_abandoned' => 'boolean',
        'is_short_miss' => 'boolean',

        // Numeric fields
        'ring_duration_seconds' => 'integer',
        'time_to_answer_seconds' => 'integer',
        'talk_time_seconds' => 'integer',
    ];

    /**
     * Get the original StasisStartEvent that initiated this call (inbound leg).
     */
    public function stasisStart(): BelongsTo
    {
        return $this->belongsTo(StasisStartEvent::class, 'stasis_start_event_id');
    }

    /**
     * Get the final StasisEndEvent that terminated the call.
     */
    public function stasisEnd(): BelongsTo
    {
        // This relationship is nullable since a call might still be active (end_time is null)
        return $this->belongsTo(StasisEndEvent::class, 'stasis_end_event_id');
    }
}