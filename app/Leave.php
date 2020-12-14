<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Leave extends Model
{
    protected $guarded = array('id');
    
    
    public static $rules = array(
      'date' => 'after:day'
      
    );
    
    
    
    
    public function messages()  {
      return [
        'date.after:today' => '希望日付は現在日付より後の日付を入力してください。'
      ];
    }
    
    
    
    public function user()
    {
      return $this->belongsTo('App\User');
    }
    
    public function leaveReasonMaster()
    {
      return $this->belongsTo('App\LeaveReasonMaster');
    }
}