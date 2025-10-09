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

    protected function optionName(): Attribute
    {
        return new Attribute(
            // The accessor function
            get: fn($value, $attributes) => $attributes['option'],
        );
    }
    protected function description(): Attribute
    {
        return new Attribute(
            // The accessor function
            get: fn($value, $attributes) => $attributes['description'],
        );
    }

    public function myContext()
    {
        return  $this->belongsTo(ContextsModel::class, 'context', 'id');
    }
}
