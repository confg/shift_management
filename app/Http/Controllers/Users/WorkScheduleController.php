<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Work;
use Illuminate\Support\Facades\Auth;


class WorkScheduleController extends Controller
{
    public function add() {
        date_default_timezone_set('Asia/Tokyo');
        
    
        return view('users.work_schedule.my_work_schedule', ['dates' => $this->getCalendarDates(2020,6), 'currentMonth' => 6, 'currentYear' => 2020]);
    }
    
    public function whole() {
        
        return view('users.work_schedule.whole_work_schedule');
    }
    
    public function date(Request $request) {
        
        $month = $request->input('currentMonth');
        $year = $request->input('currentYear');
        $day = $request->input('currentDay');
        
        $date = $year.'-'.$month.'-'.$day;

        $work = DB::table('works')
        ->where('create_users_id', Auth::id())
        ->whereDate('target_date', $date)
        ->first();
        
        
        
        return view('users.work_schedule.date_work_schedule',[ 'work' => $work , 'date' => $date ]);
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
        $work->create_users_id = Auth::id();
        $work->target_date = $form['date'];
        $work->save();
        
        return redirect('users.work_schedule.date_work_schedule');
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
}