<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class WorkScheduleController extends Controller
{
    public function add() {
        
        return view('users.work_schedule.my_work_schedule', ['dates' => $this->getCalendarDates(2020,6), 'currentMonth' => 6]);
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
