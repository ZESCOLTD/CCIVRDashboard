<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Live\CCAgent;

class AgentBreak extends Model
{
    use HasFactory;

    protected $table = 'agent_breaks';

    protected $fillable = [
        'agent_id',
        'started_at',
        'ended_at',
    ];

    // To this:
protected $casts = [
    'started_at' => 'datetime',
    'ended_at' => 'datetime',
];

    // Relationship to Agent
    public function agent()
    {
        return $this->belongsTo(CCAgent::class);
    }

    // Calculate duration in seconds (if ended)
    public function getDurationInSecondsAttribute(): int
    {
        if (!$this->ended_at) {
            return now()->diffInSeconds($this->started_at);
        }

        return $this->ended_at->diffInSeconds($this->started_at);
    }

    // Human-readable duration
    public function getDurationForHumansAttribute(): string
    {
        $seconds = $this->duration_in_seconds;

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}