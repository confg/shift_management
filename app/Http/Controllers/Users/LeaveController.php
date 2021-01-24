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
        
        return view('users.leave.application',[ 'user' => $this->getUserName(Auth::id()), 'all' => $all]);
    }
    
    
    public function application(Request $request) {
        
        $leave = new Leave;
        $update = $request->date;
        $form = $request->all();
        
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
        $leave->update([
            'permit' => null
            ]);
        $leave->save();
        
        return redirect('users/mypage');
    }
    
    
    
    public function management(Request $request){
        
        $sort = $request->sort;
        $sort_order = $request->sort_order;
        $reply = $request->reply;
        $cause = $request->cause;
        $suggested_date = $request->suggested_date;
        $application_date = $request->application_date;
        $leave_reason_master_id = $request->leave_reason_master_id;
        $cond_name = $request->cond_name;
        
        $leave_type = LeaveReasonMaster::all();
        
        $leave = Leave::orderBy('created_at', 'desc');
        
        if($sort_order == 'user_id' || $sort == 'asc') {
            if($application_date == '' && $sort == 'asc') {
                $leave = Leave::select('leaves.*')
                ->join('users', 'leaves.user_id', '=', 'users.id')
                ->orderByRaw('CAST(users.name AS char) asc');
            }elseif($application_date == '' && $sort == 'desc') {
                $leave = Leave::select('leaves.*')
                ->join('users', 'leaves.user_id', '=', 'users.id')
                ->orderByRaw('CAST(users.name AS char) desc');
            }
        }elseif($sort_order != '') {
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
        
        if($application_date != '') {
          $leave->where('created_at','like','%'.$application_date.'%');
        }
        
        if($leave_reason_master_id != '') {
          $leave->where('leave_reason_master_id', $leave_reason_master_id);
        }
        
        $users = User::where('name','like','%'.$cond_name.'%')->first();
        if($cond_name != '') {
          $users = User::where('name','like','%'.$cond_name.'%')->get();
          $ids = $users->pluck('id');
          $leave->whereIn('user_id', $ids);
        }
        
        $manage = $leave->Paginate(10);
        $selected5 = '';
        
        $selected = array(
            'suggested_date' => $sort_order == 'date',
            'user_name' => $sort_order == 'user_id',
            'created_at' => $sort_order == 'created_at',
        );
        
        $sort1 = array(
            'asc' => $sort == 'asc',
            'desc' => $sort == 'desc'
        );
        
        if($reply == 'post') {
            $selected5 = 'checked';
        }
       
        return view('users.leave.management', [ 'manage' => $manage, 'cond_name' => $cond_name, 'cause' => $cause, 'suggested_date' => $suggested_date, 'leave_type' => $leave_type, 'leave_reason_master_id' => $leave_reason_master_id, 'application_date' => $application_date, 'selected' => $selected, 'sort1' => $sort1, 'selected5' => $selected5 ]);
    }
    
    
    public function front(Request $request) {
        
        $front = Leave::find($request->id);
        
        return view('users.leave.front', [ 'front' => $front]);
    }
    
    public function result() {
        
        $leave = Leave::where('user_id', Auth::id())
        ->where('permit', '!=', null)
        ->orderBy('date', 'desc')
        ->Paginate(10);
        
        
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
        
        $permitFlg = false;
        
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
