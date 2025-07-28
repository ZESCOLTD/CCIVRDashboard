<?php

namespace App\Models;

use App\Enums\MenuType;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UssdSession extends Model
{
    use HasFactory, CastsEnums;
    protected $connection = 'omni_channel';
    public $timestamps = false;
    protected $primaryKey = 'SESSION_ID';
    protected $guarded = [];

    public $casts = [
        'menu' => MenuType::class
    ];

    public static function colors(){
        return collect([
            'airtel' => '#F70000',
            'mtn' => '#FFCB05',
            'whatsapp' => '#34B7F1',
            'zamtel' => '#20AC49',
        ]);
}
}
