<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigDestinationsModel extends Model
{
    use HasFactory;

    protected $table = 'config_destinations';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'context',
        'destination',
        'description',
        'option'
    ];

    protected $with = [
        'myContext'
    ];

    public function myContext(){
      return  $this->belongsTo(ContextsModel::class, 'context', 'id');
    }
}
