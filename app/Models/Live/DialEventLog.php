<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DialEventLog extends Model
{
    use HasFactory;
    protected $table = 'dial_event_logs';

    protected $fillable = [
        'event_type',
        'event_timestamp',
        'dialstatus',
        'forward',
        'dialstring',
        'asterisk_id',
        'application',
        'peer_id',
        'peer_name',
        'peer_state',
        'peer_protocol_id',
        'peer_accountcode',
        'peer_creationtime',
        'peer_language',
        'caller_name',
        'caller_number',
        'connected_name',
        'connected_number',
        'dialplan_context',
        'dialplan_exten',
        'dialplan_priority',
        'dialplan_app_name',
        'dialplan_app_data',
    ];

    protected $casts = [
        'event_timestamp' => 'datetime',
        'peer_creationtime' => 'datetime',
    ];



    public function scopeMissed($query)
    {
        return $query->select( 'dialstring')
            ->where('dialstatus', 'RINGING')
            ->whereNotNull('dialstring')
            ->whereNotExists(function ($subquery) {
                $subquery->selectRaw(1)
                    ->from('dial_event_logs as del2')
                    ->whereColumn('del2.dialstring', 'dial_event_logs.dialstring')
                    ->where('del2.dialstatus', 'ANSWER');
            })
            ->groupBy( 'dialstring');
    }


// public function scopeMissed($query)
// {
//     return $query->select('asterisk_id', 'dialstring')
//         ->where('dialstatus', 'RINGING')
//         ->whereNotNull('asterisk_id')
//         ->whereNotExists(function ($subquery) {
//             $subquery->selectRaw(1)
//                 ->from('dial_event_logs as del2')
//                 ->whereColumn('del2.asterisk_id', 'dial_event_logs.asterisk_id')
//                 ->where('del2.dialstatus', 'ANSWER');
//         })
//         ->groupBy('asterisk_id', 'dialstring');
// }

public function scopeAnswered($query)
{
    return $query->where('dialstatus', 'ANSWER')
                 ->where('peer_state', 'Up')
                 ->whereNotNull('peer_name')
                 ->orderBy('event_timestamp', 'desc');
}
}