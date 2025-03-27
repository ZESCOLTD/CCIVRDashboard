<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallEvent extends Model
{
    use HasFactory;

    protected $table = 'calls_event';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'type',
        'event'
    ];
}
