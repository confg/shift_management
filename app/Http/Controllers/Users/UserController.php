<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
   
    
    
    public function add() {
        
        $user = DB::table('users')
        ->where('id', Auth::id())
        ->first();
        
        //var_dump($user);
        
        return view('users.mypage', [ 'user' => $user ]);
    }
}
