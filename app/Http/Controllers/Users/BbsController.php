<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bbs;

class BbsController extends Controller
{
    public function add()
    {
      
      return view('users.bbs.bbs_list');
    }
  
    public function create()
    {
      
      return view('users.bbs.bbs_create');
      
    }
    
    public function front() {
      
      return view('users.bbs.bbs_front');
      
    }
}
