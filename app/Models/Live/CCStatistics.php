<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCStatistics extends Model
{
    use HasFactory;

    protected $table = 'statistics';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'receivedCalls',
        'missedCalls',
        'answereCalls',
        'agentTerminatedCalls',
        'callerTerminatedCalls',
        'dialedCalls',
        'unknownStateCallsTried',
    ];
}
