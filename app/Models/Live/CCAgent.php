<?php

namespace App\Models\Live;

use App\Models\CDR\CallDetailsRecordModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
        'status',
        'user_status'
    ];

    protected $with = ['user'];

    // Add these to get auto-accessible in array/json output
    protected $appends = ['is_online', 'last_seen'];

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

    // Add this accessor to show online status
    public function getIsOnlineAttribute()
    {
        return $this->user_id ? Cache::has('user-is-online-' . $this->user_id) : false;
    }

    // Add this accessor to show last seen time
    public function getLastSeenAttribute()
    {
        return $this->user_id ? Cache::get('last-seen-' . $this->user_id) : null;
    }
}

