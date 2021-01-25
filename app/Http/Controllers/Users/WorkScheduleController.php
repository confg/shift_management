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
use App\Attendance;
use Illuminate\Support\Facades\Auth;


class WorkScheduleController extends Controller
{
    public function add() {
        date_default_timezone_set('Asia/Tokyo');
        
        $year = date('Y');
        $intyear = intval($year);
        
        $month = date('m');
        $intmonth = intval($month);
        
        return view('users.work_schedule.my', ['dates' => $this->CalendarTest($year,$month), 'currentMonth' => $intmonth, 'currentYear' => $intyear]);
    }
    
    public function monthmove(Request $request) {
        
        $now = new \DateTime();
        
        $currentYear = $request->input('currentYear');
        $currentMonth = $request->input('currentMonth');
        $zenngetu = $request->input('mode');
        
        $now->setdate($currentYear,$currentMonth,1);
        
        $now->modify($zenngetu.' month');
        
        return view('users.work_schedule.my', ['dates' => $this->CalendarTest($now->format('Y'), $now->format('m')), 'currentMonth' => $now->format('m'), 'currentYear' => $now->format('Y')]);
    }
    
    public function getUserName($user_id) {
        $username = DB::table('users')
        ->select('name')
        ->where('id',$user_id)
        ->first();
        
        return $username->name;
    }
    
    public function whole(Request $request) {
        date_default_timezone_set('Asia/Tokyo');
        
        $date = date('n月j日');
        
        $target_date = $request->target_date;
        
        if($target_date == '') {
            $target_date = date('Y-m-d');
        }else {
            $date = date('n月j日',strtotime($request->target_date));
        }
        
        $uniqueday = DB::table('works')
        ->select(DB::raw('user_id, max(target_date) as max_target_date'))
        ->whereDate('target_date', $target_date)
        ->groupBy('user_id')
        ->get();
        
        $result = array();
        
        foreach($uniqueday as $uniques) {
            $user_id = $uniques->user_id;
            $updated_at = $uniques->max_target_date;
            
            $starttime = DB::table('works')
            ->where('user_id', $user_id)
            ->where('target_date', $updated_at)
            ->first();
            
            array_push($result, $starttime);
        }
        
        foreach($result as $a) {
            $a->username = $this->getUserName($a->user_id);
        }
        
        $work = Work::all();
        
        return view('users.work_schedule.whole', ['date' => $date , 'work' => $work , 'result' => $result]);
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
        
        if($work == null) {
            $work = new Work;
        }
        
        
        
        return view('users.work_schedule.date',[ 'work' => $work , 'date' => $date , 'selectDay' => $day , 'selectMonth' => $month ]);
    }
    
    public function update(Request $request) {
        
        $work = new Work;
        $form = $request->all();
        
        $this->validate($request, Work::$rules);
        
        $starttime = $request->strattime;
        $endtime = $request->endtime;
        
        if($form['id']) {
            $work = Work::find($request->id);
        }
        
        $date_boder = false;
        
        if(isset($request['today'])) {
            $date_boder = true;
        }elseif (isset($request['next_day'])) {
            $date_boder = false;
        }
        
        $work->fill($form);
        $work->user_id = Auth::id();
        $work->save();
       
        return redirect('users/work_schedule/my');
    }
    
    public function CalendarTest($year,$month) {
        $last_day = date('j', mktime(0, 0, 0, $month + 1, 0, $year));
        
        $calendar = array();
        $j = 0;
        
        for ($i = 1; $i < $last_day + 1; $i++) {
            $week = date('w', mktime(0, 0, 0, $month, $i, $year));
            if ($i == 1) {
                for ($s = 1; $s <= $week; $s++) {
                    $calendar[$j]['day'] = '';
                    $j++;
                }
            }
         
            $calendar[$j]['day'] = $i;
            $j++;
         
            if ($i == $last_day) {
                for ($e = 1; $e <= 6 - $week; $e++) {
                    $calendar[$j]['day'] = '';
                    $j++;
                }
            }
        }
        return $calendar;
    }
    
    public function getCalendarDates($year, $month)
    {
        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        
        $date = new Carbon($dateStr);
        
        $date->subDay($date->dayOfWeek);
        
        $count = 31 + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            $dates[] = $date->copy();
        }
        return $dates;
    }
    
    public function attendance(Request $request) {
        
        $work = new Work;
        $update = array();
        
        if(isset($request['attendance'])) {
            $update = ['attendance' => $work->attendance = date('H:i:s')];
        }elseif(isset($request['leaving'])) {
            $update = [
            'leaving' => $work->leaving = date('H:i:s'),
            'leaving_date' => $work->leaving_date = date("Y-m-d"),
            ];
        }
        //dd($update);
        
        DB::table('works')
        ->where('id', $request->id)
        ->update($update);
        
        return $this->add();
    }
    
}