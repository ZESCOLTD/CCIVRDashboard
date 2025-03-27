<?php

namespace App\Models\Live;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\CDR\CallDetailsRecordModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Recordings extends Model
{
    use HasFactory;

    protected $table = 'recordings';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'agent_number',
        'phone_number',
        'duration_number',
        'file_name',
        'file_path',
        'agent_no',
        'user_id',
        'session_id',
        'src',
        'dst',
        'clid',
        'calldate',
        'answerdate',
        'hangupdate',
        'duration',
        'billsec',
        'disposition',
        'transaction_code'
    ];

    protected $with = ['tCode'];

    public function myUser()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function callDetails()
    {
        return $this->belongsTo(CallDetailsRecordModel::class, 'agent_number', 'dst');
    }

    public function agent()
    {
        return $this->belongsTo(CCAgent::class, 'dst', 'endpoint');
    }

    public function tCode()
    {
        // return $this->belongsTo(TransactionCode::class, 'code', 'transaction_code');
        return $this->belongsTo(TransactionCode::class, 'transaction_code', 'code');
    }

    // Accessor to calculate and format duration
    public function getCallDurationAttribute()
    {
        $answerDate = Carbon::parse($this->answerdate);
        $hangupDate = Carbon::parse($this->hangupdate);
        $durationInSeconds = $hangupDate->diffInSeconds($answerDate);

        if ($durationInSeconds < 60) {
            return $durationInSeconds . ' sec';
        }

        $minutes = floor($durationInSeconds / 60);
        $seconds = $durationInSeconds % 60;

        if ($seconds == 0) {
            return $minutes . ' min';
        }

        return $minutes . ' min ' . $seconds . ' sec';
    }

    public function comments()
    {
        return $this->hasMany(RecordingComment::class, 'recordings_id', 'id');
    }
}
