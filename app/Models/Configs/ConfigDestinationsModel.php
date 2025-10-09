<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function getOptionNameAttribute()
    {
        return $this->option;
    }
    protected function description(): Attribute
    {
        return $this->description;
    }

    public function myContext()
    {
        return  $this->belongsTo(ContextsModel::class, 'context', 'id');
    }
}
