<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkScheduleController extends Controller
{
    public function add() {
        
        return view('users.work_schedule.my_work_schedule');
    }
    
    public function whole() {
        
        return view('users.work_schedule.whole_work_schedule');
    }
    
    public function date() {
        
        return view('users.work_schedule.date_work_schedule');
    }
    
    public function leave() {
        
        return view('users.work_schedule.leave_application');
    }
}
