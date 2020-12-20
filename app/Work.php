<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $guarded = array('id');
    
    public static $rules = array(
      'endtime' => 'datecheck'
      
    );
    
    public function user()
    {
      return $this->belongsTo('App\User');
    }
    
}
