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
        
        //ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        
        return view('users.leave.application',[ 'user' => $this->getUserName(Auth::id()), 'all' => $all]);
    }
    
    
    public function application(Request $request) {
        
        $leave = new Leave;
        $update = $request->date;
        $form = $request->all();
        
        //ログインユーザーの希望日付のリクエストのID
        $target = DB::table('leaves')
        ->where('date',$update)
        ->where('user_id',Auth::id())
        ->first();
        
        if($target != null) {
            $leave = Leave::find($target->id);
        }
        
        
        $this->validate($request, Leave::$rules);
        
        $leave->fill($form);
        $leave->user_id = Auth::id();
        $leave->save();
        
        return redirect('users/mypage');
    }
    
    
    
    public function management(Request $request){
        
        $sort = $request->sort;
        $sort_order = $request->sort_order;
        $reply = $request->reply;
        $cause = $request->cause;
        $suggested_date = $request->suggested_date;
        $leave_reason_master_id = $request->leave_reason_master_id;
        $cond_name = $request->cond_name;
        
        $leave_type = LeaveReasonMaster::all();
        
        $leave = Leave::orderBy('created_at', 'desc');
        
        if($sort_order != '') {
          $leave = Leave::orderBy($sort_order, $sort);
        }
        
        
        if($reply != '') {
          $leave->where('permit', null);
        }
        
        if($cause != '') {
          $leave->where('text','like','%'.$cause.'%');
        }
        
        if($suggested_date != '') {
          $leave->where('date','like','%'.$suggested_date.'%');
        }
        
        if($leave_reason_master_id != '') {
          $leave->where('leave_reason_master_id', $leave_reason_master_id);
        }
        
        $user = User::where('name','like','%'.$cond_name.'%')->first();
        if($cond_name != '') {
          if (is_null($user)){
            $leave->where('id', null);
          } else {
            $leave->where('user_id', $user->id);
          }
        }
        
        $manage = $leave->simplePaginate(10);
        
        
        //ini_set('xdebug.var_display_max_children', -1); ini_set('xdebug.var_display_max_data', -1); ini_set('xdebug.var_display_max_depth', -1);
        //var_dump($leave);
        
        
        $selected1 = '';
        $selected2 = '';
        $selected3 = '';
        $selected4 = '';
        $selected5 = '';
        $selected6 = '';
        $selected7 = '';
        
        if($sort_order == 'date') {
            $selected1 = 'selected';
        }
        if($sort_order == 'user_id') {
            $selected2 = 'selected';
        }
        if($sort_order == 'text') {
            $selected3 = 'selected';
        }
        if($sort == 'desc') {
            $selected4 = 'selected';
        }
        if($sort == 'asc') {
            $selected5 = 'selected';
        }
        if($reply == 'post') {
            $selected6 = 'checked';
        }
        if(isset($leave_reason_master_id)) {
            $selected7 = 'selected';
        }
       
        return view('users.leave.management', [ 'manage' => $manage, 'cond_name' => $cond_name, 'cause' => $cause, 'suggested_date' => $suggested_date, 'leave_type' => $leave_type, 'selected1' => $selected1, 'selected2' => $selected2, 'selected3' => $selected3, 'selected4' => $selected4, 'selected5' => $selected5, 'selected6' => $selected6, 'selected7' => $selected7 ]);
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
}
