<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherChannel extends Model
{
    use HasFactory;

    protected $table = 'other_channels';

    protected $connection = 'asterisk_mysql';
    protected $fillable = ['channel_name', 'channel_date', 'total', 'details'];



    protected $casts = [
        'details' => 'array',
    ];
}
