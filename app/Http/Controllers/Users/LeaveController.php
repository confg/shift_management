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
        
        
        /*
        ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        var_dump($all);
        */
        
        return view('users.leave.application',[ 'user' => $this->getUserName(Auth::id()), 'all' => $all ]);
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
        
        
        return redirect('users/mypage');
    }
    
    
    
    public function management(Request $request){
        
        $sort = $request->sort;
        $reply = $request->reply;
        $cond_name = $request->cond_name;
        
        if($reply == '' && $cond_name == '') {
            $manage = Leave::orderBy('created_at', $sort)
            ->simplePaginate(10);
        }
        
        
        
        if ($reply == 'post' && $sort == 'asc') {
            $manage = Leave::where('permit', null)
            ->orderBy('created_at', $sort)
            ->simplePaginate(10);
        }
        
        
        $user = User::where('name', $cond_name)->first();
        
        if($cond_name != '') {
            
            if(is_null($user)) {
                $manage = Leave::where('id', null)
                ->simplePaginate(10);
            } else {
                $manage = $user->leave()
                ->orderBy('created_at', $sort)
                ->simplePaginate(10);
            }
        }
        
        if($reply == 'post' && $cond_name != '') {
            if(is_null($user)) {
              $manage = Leave::where('id', null)->simplePaginate(10);
            } else {
              $manage = Leave::where('user_id', $user->id)
              ->where('permit', null)
              ->orderBy('created_at', $sort)
              ->simplePaginate(10);
            }
        }
       
        
        $selected1 = '';
        $selected2 = '';
        
        if($sort == 'asc') {
            $selected1 = 'selected';
        } else {
            $selected2 = 'selected';
        }
        
        $selected3 = '';
        if($reply == 'post') {
            $selected3 = 'selected';
        }
        
        ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        var_dump($sort);
        var_dump($cond_name);
       
        return view('users.leave.management', [ 'manage' => $manage, 'cond_name' => $cond_name, 'selected1' => $selected1, 'selected2' => $selected2, 'selected3' => $selected3 ]);
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
        ->update([
            'permit' => $permitFlg,
            'comment' => $request->comment
        ]);
        
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
