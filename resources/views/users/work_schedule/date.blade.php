@extends('layouts.admin')

@section('content')
<body>
    <h1>日付のページ</h1>
    <h2>{{ $selectMonth.'月'.$selectDay.'日' }}</h2>
    <div>
        <div>
            <div>
                <form action="{{ action('Users\WorkScheduleController@attendance', [ 'id' => $work ]) }}" method="post">
                    {{ csrf_field() }}
                    @if( date("Y-m-j") == $date)
                       <input type="submit" name="attendance" value="出勤"/>
                       <input type="submit" name="leaving" value="退勤"/>
                    @endif
                </form>
                
                <form action="{{ action('Users\WorkScheduleController@update') }}" method="post">
                    <div>
                        <p>予定出勤時間</p>
                        <input type="time" min="0:00" max="23:59" required name="starttime" value="{{ old('starttime') }}">
                    </div>
                    
                    <div>
                        <p>予定退勤時間</p>
                        <input type="time" min="0:00" max="23:59" required name="endtime" value="{{ old('endtime') }}">
                    </div>
                    <div>
                        <input type="submit" value="更新">
                    </div>
                    
                    </div>
                    @if ( $work != null )
                        <input type="hidden" name="id" value="{{ $work->id }}">
                    @else
                        <input type="hidden" name="id" value="">
                    @endif
                    <input type="hidden" name="target_date"  value="{{ $date }}">
                    {{ csrf_field() }}
                </form>
                <div>
                    <h2>{{ $selectMonth.'月'.$selectDay.'日の予定' }}</h2>
                    @if($work != '')
                        <div>{{ date('G時i分',  strtotime($work->starttime))."から".date('G時i分',  strtotime($work->endtime))."まで" }}</div>
                    @else
                    <h2>未入力</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
@endsection