<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $guarded = array('id');
    
    
    
    public function user()
    {
      return $this->belongsTo('App\User');
    }
    
    public function leaveReasonMaster()
    {
      return $this->belongsTo('App\LeaveReasonMaster');
    }
}