<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function bbs() {
        
        return $this->hasMany('App\Bbs');
    }
    
    public function work() {
        
        return $this->hasMany('App\Work');
    }
    
    public function leave()
    {
        return $this->hasMany('App\Leave');
    }
}
