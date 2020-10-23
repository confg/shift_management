<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Work;
use App\Bbs;
use App\User;
use App\Leave;
use App\LeaveReasonMaster;
use Illuminate\Support\Facades\Auth;



class LeaveController extends Controller
{
    
    public function leave(Request $request) {
        
        
        
        $all = LeaveReasonMaster::all();
        
        ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        var_dump($all);
        
        return view('users.leave.application',[ 'user' => $this->getUserName(Auth::id()), 'all' => $all]);
    }
    
    
    public function application(Request $request) {
        
        $leave = new Leave;
        $form = $request->all();
        
        
        
        //idが渡ってきた前提
        $app = Leave::find($request->id);
        
        
        
        
        $leave->fill($form);
        $leave->user_id = Auth::id();
        $leave->save();
        
        
        return redirect('users/mypege');
    }
    
    
    
    public function management(){
        
        //$manage = Leave::all();
        
        $manage = Leave::whereNull('permit')
        ->get();
        
        //ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        
       
        
        
        return view('users.leave.management', [ 'manage' => $manage]);
    }
    
    
    public function front(Request $request) {
        
        
        
        $tests = Leave::find($request->id);
        
        
        return view('users.leave.front', [ 'tests' => $tests]);
    }
    
    public function result() {
        
        $leave = Leave::where('user_id', Auth::id())
        ->where('permit', '!=', null)
        ->get();
        
        
        return view('users.leave.result', [ 'leave' => $leave]); 
    }
    
    public function getUserName($user_id) {
        $username = DB::table('users')
        ->select('name')
        ->where('id',$user_id)
        
        
        ->first();
        
        return $username->name;
    }
    
    public function update(Request $request) {
        //なんの型なのかわかるように
        $permitFlg = false;
        
        //ボタンからきたリクエストをデータベースに入る形に変える
        //permitとblockingはtest.bladeファイルのname属性
        if(isset($request['permit'])) {
            $permitFlg = true;
        }elseif(isset($request['blocking'])) {
            $permitFlg = false;
        }
       
       
        DB::table('leaves')
        ->where('id', $request->id)
        ->update(['permit' => $permitFlg]);
        
        
        
        $manage = Leave::whereNull('permit')
        ->get();
        
        return view('users.leave.management', [ 'manage' => $manage]);
    }
}
