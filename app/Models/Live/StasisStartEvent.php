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


}