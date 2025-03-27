<?php

namespace App\Models\CDR;

use App\Models\Configs\ConfigDestinationsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CallDetailsRecordModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'cdr';
    protected $connection = 'asterisk_mysql';
    protected $primaryKey = 'id';
    protected $fillable = [
        'accountcode',
        'src',
        'dst',
        'dcontext',
        'clid',
        'channel',
        'dstchannel',
        'lastapp',
        'lastdata',
        'calldate',
        'answerdate',
        'hangupdate',
        'duration',
        'billsec',
        'disposition',
        'amaflags',
        'uniqueid',
        'userfield'
    ];

    protected $casts = [
        'calldate' => 'datetime',
        'answerdate' => 'datetime',
        'hangupdate' => 'datetime',
    ];

    protected $with = [
        'myDestination'
    ];
    public function myDestination() {
        return $this->belongsTo(ConfigDestinationsModel::class, 'dst', 'destination');
    }


}
