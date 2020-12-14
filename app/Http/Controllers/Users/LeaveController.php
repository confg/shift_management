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
        date_default_timezone_set('Asia/Tokyo');
        
        
        $all = LeaveReasonMaster::all();
        
        $day = date('Y-m-d');
        
        /*
        ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        var_dump($all);
        */
        
        return view('users.leave.application',[ 'user' => $this->getUserName(Auth::id()), 'all' => $all, 'day' => $day ]);
    }
    
    
    public function application(Request $request) {
        
        $leave = new Leave;
        $form = $request->all();
        
        $this->validate($request, Leave::$rules);
        
        //idが渡ってきた前提
        $app = Leave::find($request->id);
        
        
        
        
        $leave->fill($form);
        $leave->user_id = Auth::id();
        $leave->save();
        
        
        return redirect('users/mypege');
    }
    
    
    
    public function management(Request $request){
        
        
        $manage = Leave::orderBy('id', 'desc')
        ->simplePaginate(10);
        
        //ソート機能
        $sort = $request->sort;
        if ($sort == 'asc') {
            $manage = Leave::orderBy('id', 'asc')->simplePaginate(10);
        }elseif($sort == 'desc') {
            $manage = Leave::orderBy('id', 'desc')->simplePaginate(10);
        }
        
        //未返答のデータのみ表示
        $reply = $request->reply;
        if ($reply == 'post' && $sort == 'asc') {
            $manage = Leave::where('permit', null)
            ->orderBy('created_at', 'asc')
            ->simplePaginate(10);
        }elseif($reply == 'post' && $sort == 'desc') {
            $manage = Leave::where('permit', null)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
        }
        
        //名前の検索
        $cond_name = $request->cond_name;
        if($sort == 'asc' && $cond_name != '') {
            $user = User::where('name', $cond_name)->first();
            $manage = $user->leave()
            ->orderBy('created_at', 'asc')
            ->simplePaginate(10);
        }elseif($sort == 'desc' && $cond_name != '') {
            $user = User::where('name', $cond_name)->first();
            $manage = $user->leave()
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
        }
        
        ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        var_dump($sort);
        var_dump($cond_name);
       
        return view('users.leave.management', [ 'manage' => $manage, 'cond_name' => $cond_name ]);
    }
    
    
    public function front(Request $request) {
        
        
        
        $tests = Leave::find($request->id);
        
        var_dump($tests);
        
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
        
        $manage = Leave::find($request->id);
        
        //なんの型なのかわかるように
        $permitFlg = false;
        
        //ボタンからきたリクエストをデータベースに入る形に変える
        //permit��blockingはfront.bladeファイルのname属性
        if(isset($request['permit'])) {
            $permitFlg = true;
        }elseif(isset($request['blocking'])) {
            $permitFlg = false;
        }
        
        
        
        DB::table('leaves')
        ->where('id', $request->id)
        ->update(['permit' => $permitFlg]);
        
        
        DB::table('leaves')
        ->where('id', $request->id)
        ->update(['comment' => $request->comment]);
        
        
        $manage = Leave::orderBy('id', 'desc')
        ->simplePaginate(10);
        
        return redirect('users/leave/management');
    }
    
    public function delete(Request $request)
    {
      
      $leave = Leave::find($request->id);
      
      $leave->delete();
      
      return redirect('users/leave/result');
    }
}
