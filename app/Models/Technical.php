<?php

namespace App\Imports;
namespace App\Models;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    protected $table = 'technicals';
    protected $fillable = [

        'topic',
        'description',
        'last_updated',
        'views',

    ];
    protected $casts = [
        'last_updated' => 'datetime',
    ];
}
