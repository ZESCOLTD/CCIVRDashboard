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
        //'region',
        //'zone',
        'division',
        'service_no',
        'service_point',
        //'csc',
        //'tariff',
        'itinerary_assigned',
        //'declared_demand',
        'premise_id',
        'customer_name',
        'meter_no',
        'meter_serial_no',
        'meter_make',
        'meter_type_code',
        'meter_status',
        'phase_type',
        'phase_type',
        'voltage_type',
        'meter_rating',
        'meter_constant',
        'meter_instal_date',
        'town',
        'meter_type',
        'connection_type',
        //'province',
        //'township',
        //'street',
        //'address',
        // 'home_phone',
        // 'buss_phone',
        // 'other_phone',
    ];
}
