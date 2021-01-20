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
        
        //modeに+1と-1の値を与える、リクエストで受け取る、modify()の引数の中に変数と文字列で結合する
        $now->modify($zenngetu.' month');
        
        return view('users.work_schedule.my', ['dates' => $this->CalendarTest($now->format('Y'), $now->format('m')), 'currentMonth' => $now->format('m'), 'currentYear' => $now->format('Y')]);
    }
    
    //名前をとるメソッド
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
            $date = date('m月j日',strtotime($request->target_date));
        }
        
        //user_idの重複をのぞくtarget_dateの一番大きい値の検索
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
        //input URL以外の情報を詰め込んでくれる　取得するメソッド
        //$requestは連想配列
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
        
        //$formにworksテーブルのidがあれば更新
        //ifが更新
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
    
    
    
    //外からきた変数で使える状態に
    public function CalendarTest($year,$month) {
        
        // 月末日を取得
        $last_day = date('j', mktime(0, 0, 0, $month + 1, 0, $year));
         
        $calendar = array();
        $j = 0;
         
        // 月末日までループ
        for ($i = 1; $i < $last_day + 1; $i++) {
         
            // 曜日を取得
            $week = date('w', mktime(0, 0, 0, $month, $i, $year));
         
            // 1日の場合
            if ($i == 1) {
                
                // 1日目の週末日までをループ
                for ($s = 1; $s <= $week; $s++) {
                    
                    // 前半に空文字をセット
                    $calendar[$j]['day'] = '';
                    $j++;
                }
            }
         
            // 配列に日付をセット
            $calendar[$j]['day'] = $i;
            $j++;
         
            // 月末日の場合
            if ($i == $last_day) {
                
                // 月末日から残りをループ
                for ($e = 1; $e <= 6 - $week; $e++) {
                    
                    // 後半に空文字をセット
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
    
    public function attendance(Request $request) {
        
        $work = new Work;
        
        //updateのなかの連想配列をif文の中で分岐させる
        //空の配列を忘れずに
        $update = array();
        
        if(isset($request['attendance'])) {
            $update = ['attendance' => $work->attendance = date("H:i:s")];
        }elseif(isset($request['leaving'])) {
            $update = [
            'leaving' => $work->leaving = date("H:i:s"),
            'leaving_date' => $work->leaving_date = date("Y-m-d"),
            ];
        }
        
        DB::table('works')
        ->where('id', $request->id)
        ->update($update);
        
        return $this->add();
    }
    
}