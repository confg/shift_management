<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Work;
use App\Bbs;
use App\User;
use Illuminate\Support\Facades\Auth;


class WorkScheduleController extends Controller
{
    public function add() {
        date_default_timezone_set('Asia/Tokyo');
        
        $year = date('Y');
        $intyear = intval($year);
        
        $month = date('m');
        $intmonth = intval($month);
        
        
    
        return view('users.work_schedule.my_work_schedule', ['dates' => $this->getCalendarDates($intyear,$intmonth), 'currentMonth' => $intmonth, 'currentYear' => $intyear]);
    }
    
    //名前をとるメソッド
    public function getUserName($user_id) {
        $username = DB::table('users')
        ->select('name')
        ->where('id','=',$user_id)
        ->first();
        
        return $username->name;
    } 
    
    public function whole() {
        date_default_timezone_set('Asia/Tokyo');
        
        $date = date('m/d');
        
        
        
        $uniqueday = DB::table('works')
        ->select(DB::raw('max(id), user_id, max(updated_at)'))
        ->whereDate('target_date', date('Y-m-d'))
        ->groupBy('user_id')
        ->get();
        
        
        foreach($uniqueday as $a) {
        $a->username = $this->getUserName($a->user_id);
        }
        var_dump($uniqueday);
        
        $work = Work::all();
        
        
        return view('users.work_schedule.whole_work_schedule', ['date' => $date , 'work' => $work , 'uniqueday' => $uniqueday ]);
    }
    
    public function date(Request $request) {
        
        $month = $request->input('currentMonth');
        $year = $request->input('currentYear');
        $day = $request->input('currentDay');
        
        $date = $year.'-'.$month.'-'.$day;
        
        $work = DB::table('works')
        ->where('user_id', Auth::id())
        ->whereDate('target_date', $date)
        ->first();
        
        
        
        
        return view('users.work_schedule.date_work_schedule',[ 'work' => $work , 'date' => $date , 'selectDay' => $day , 'selectMonth' => $month ]);
    }
    
    public function update(Request $request) {
        
        $work = new Work;
        $form = $request->all();
        
        //$formにworksテーブルのidがあれば更新
        //ifが更新
        if($form['id']) {
            $work = Work::find($request->id);
        }
        
        
        $work->fill($form);
        $work->user_id = Auth::id();
        $work->save();
        
        return redirect('users.work_schedule.my_work_schedule');
    }
    
    public function leave() {
        
        return view('users.work_schedule.leave_application');
    }
    
    public function getCalendarDates($year, $month)
    {
        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        
        $date = new Carbon($dateStr);
        
        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $date->subDay($date->dayOfWeek);
        
        // 同上。右下の隙間のための計算。
        $count = 31 + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $date->copy();
        }
        return $dates;
    }
    
    public function sample(){
        
        return view('users.work_schedule.sample');
    }
    
}