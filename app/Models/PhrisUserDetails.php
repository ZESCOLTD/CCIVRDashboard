<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhrisUserDetails extends Model
{
    use HasFactory;

    protected $connection = 'oracle_phris';
    //table name
    protected $table  = 'ipa_phris_view';


    public $incrementing = false;
    protected $keyType = 'string';
}
