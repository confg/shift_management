<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Leave extends Model
{
    protected $guarded = array('id');
    
    
    public static $rules = array(
      'date' => 'after:today'
      
    );
    
    
    public function user()
    {
      return $this->belongsTo('App\User');
    }
    
    public function leaveReasonMaster()
    {
      return $this->belongsTo('App\LeaveReasonMaster');
    }
}