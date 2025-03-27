<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallSession extends Model
{
    use HasFactory;
    protected $table = 'call_sessions';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'name',
        'description',
        'time_from',
        'time_to'
    ];

    // protected $casts = [
    //     'time_from' => 'datetime',
    //     'time_to' => 'datetime',
    // ];
}
