<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveReasonMaster extends Model
{
    protected $guarded = array('id');
    
    
    
    public function leave()
    {
      return $this->hasOne('App\Leave');
    }
}