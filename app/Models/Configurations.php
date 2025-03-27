<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configurations extends Model
{
    use HasFactory;

    protected $table = 'configurations';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'config_key_id',
        'config_value'
    ];
}
