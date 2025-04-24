<?php
 // app/Models/Live/AgentStatus.php
 namespace App\Models\Live;

 use Illuminate\Database\Eloquent\Model;

 class AgentStatus extends Model
 {
     protected $table = 'call_sessions';
     protected $connection = 'asterisk_mysql';
 // Active agents scope
     public function scopeActive($query)
     {
         return $query->where('status', 'active');
     }

 // Relationship to current call if exists
     public function currentCall()
     {
         return $this->hasOne(CallQueue::class, 'agent_id');
     }
 }