<?php

namespace App\Models;

use App\Models\Live\CallSession;
use App\Models\Live\CCAgent;
use App\Models\Live\Recordings;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use IvanoMatteo\LaravelDeviceTracking\Traits\UseDevices;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class User extends Authenticatable
{
    //    use HasApiTokens, HasFactory, Notifiable, AuthenticationLoggable,UseDevices;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $connection = 'asterisk_mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'man_no',
        'nrc',
        'name',

        'firstname',
        'middlename',
        'lastname',

        'dob',
        'sex',

        'mobile_no',
        'email',
        'password',


        'bu_code',
        'cc_code',
        'bu_name',
        'cc_name',
        'directorate',
        'division',
        'location',
        'functional_section',
        'station',
        'position',
        'job_code',
        'job_title',
        'grade',

        'status',

        'is_banned',
        'banned_until',
        'user_group_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function myAgentDetails()
    {
        return $this->belongsTo(CCAgent::class, 'man_no', 'man_no');
    }

    public function myCallRecordings()
    {
        return $this->hasMany(Recordings::class, 'user_id', 'id');
    }

    public function myCallSessions()
    {
        return $this->hasMany(CallSession::class,'call_session_to_agent', 'agent_id', 'call_session_id');
    }
}
