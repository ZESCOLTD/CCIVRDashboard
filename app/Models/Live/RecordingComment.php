<?php

namespace App\Models\Live;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordingComment extends Model
{
    use HasFactory;

    protected $table = 'recordings_comments';
    protected $connection = 'asterisk_mysql';
    protected $fillable = [
        'recordings_id',
        'comment',
        'user_id',
        'username',
        'rating'
    ];

    
}
