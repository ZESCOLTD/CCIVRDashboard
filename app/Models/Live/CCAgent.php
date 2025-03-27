<?php

namespace App\Models\Live;

use App\Models\CDR\CallDetailsRecordModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCAgent extends Model
{
    use HasFactory;

    protected $table = 'agents';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'man_no',
        'name',
        'endpoint',
        'user_id',
        'set_number',
        'state',
        'status'
    ];

    protected $with = [
        'user'
    ];


    public function myRecordings()
    {
        return $this->hasMany(Recordings::class, 'agent_number', 'endpoint');
    }

    public function myCDRs()
    {
        return $this->belongsTo(CallDetailsRecordModel::class, 'dst', 'endpoint');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
