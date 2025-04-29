<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'prosumer_cmsdist_view';
    protected $connection = 'oracle_phris';
    protected $primaryKey = 'meter_no';
    use HasFactory;

    protected $fillable = [
        'service_no',
        'meter_serial_no',
        'complaint_no',
        'landmark',
        'phone_number',
        'customer_name',
        'complaint_type_code',
        'complaint_type_desc',
        'complaint_status_desc',

    ];
}


