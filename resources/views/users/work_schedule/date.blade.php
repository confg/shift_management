@extends('layouts.admin')

@section('content')
<body>
    
    <div class="width">
        <h1>日付のページ</h1>
        
        
        <table>
            <div class="head">
                <div class="plan-contents">
                    <h2>{{ $selectMonth.'月'.$selectDay.'日' }}</h2>
                </div>
                <div class="plan-contents plan-date">
                    <h2>{{ $selectMonth.'月'.$selectDay.'日の予定' }}</h2>
                    @if($work->starttime != null && $work->endtime != null)
                        <h3>{{ date('G時i分',  strtotime($work->starttime))."から".date('G時i分',  strtotime($work->endtime))."まで" }}</h3>
                    @else
                    <h2>未入力</h2>
                    @endif
                </div>
            </div>    
            <div class="contents">
                
                <form action="{{ action('Users\WorkScheduleController@attendance', [ 'id' => $work ]) }}" method="post">
                    {{ csrf_field() }}
                    
                    @if( date("Y-m-j") == $date && $work->leaving == '00:00:00')
                        @if($work->attendance == '00:00:00')
                            <input type="submit" name="attendance" value="出勤"/>
                        @else
                            <input type="submit" name="leaving" value="退勤"/>
                        @endif
                    @endif
                </form>
                
                <form action="{{ action('Users\WorkScheduleController@update') }}" method="post">
                    <div class="plan">
                        <div class="plan-contents">
                            <h5>予定出勤時間</h5>
                            <input class="buttom" type="time" min="0:00" max="23:59" required name="starttime" value="{{ old('starttime') }}">
                        </div>
                        
                        <div class="plan-contents">
                            <h5>予定退勤時間</h5>
                            <input class="buttom" type="time" min="0:00" max="23:59" required name="endtime" value="{{ old('endtime') }}">
                        </div>
                    </div>    
                    <div class="plan-contents">
                        <input class="buttom" type="submit" value="更新">
                    </div>
                    
                    @if ( $work != null )
                        <input type="hidden" name="id" value="{{ $work->id }}">
                    @else
                        <input type="hidden" name="id" value="">
                    @endif
                    <input type="hidden" name="target_date"  value="{{ $date }}">
                    {{ csrf_field() }}
                </form>
                
            </div>    
            
        </table>
    </div>
    
</body>
@endsection