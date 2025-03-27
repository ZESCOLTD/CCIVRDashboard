<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallSessionToAgent extends Model
{
    use HasFactory;

    protected $table = 'call_session_to_agent';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'agent_id',
        'call_session_id',
        'status',
        'time_from',
        'time_to',
        'session_name',
        'username'
    ];

    protected $casts = [
        'time_from' => 'datetime',
        'time_to' => 'datetime',
    ];
}
