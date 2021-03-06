<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bbs extends Model
{
    protected $guarded = array('id');
    
    
    
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
