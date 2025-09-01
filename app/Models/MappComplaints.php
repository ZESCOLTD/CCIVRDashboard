<?php

namespace App\Models;

use App\Enums\MenuType;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappComplaints extends Model
{
    use HasFactory, CastsEnums;
    protected $connection = 'omni_channel';
    public $timestamps = false;
    protected $primaryKey = false ;
    protected $guarded = [];

    
}
