<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BbsUser extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'bbs_id' => 'required',
        
    );
}
