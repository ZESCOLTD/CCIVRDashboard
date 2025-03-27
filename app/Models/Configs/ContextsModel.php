<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContextsModel extends Model
{
    use HasFactory; //use SoftDeletes;

    protected $table = 'contexts';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'context'
    ];

    public  function destinations(){
        return $this->hasMany(ConfigDestinationsModel::class, 'context', 'id');
    }
}
