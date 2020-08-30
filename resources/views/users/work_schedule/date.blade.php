@extends('layouts.work_schedule')

@section('content')
<body>
    <h1>日付のページ</h1>
    <h2>{{ $selectMonth.'月'.$selectDay.'日' }}</h2>
    <div>
        <div>
            <div>
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
                        <p>実働出勤時間</p>
                        <input type="time" min="0:00" max="23:59" disabled="disabled"   name="" value="">
                    </div>
                    
                    <div>
                        <p>実働退社時間</p>
                        <input type="time" min="0:00" max="23:59" disabled="disabled"   name="" value="">
                        {{ csrf_field() }}
                        <div>
                            
                            <div>
                                <input type="submit" value="更新">
                            </div>
                        </div>
                        
                    </div>
                    @if ( $work != null )
                        <input type="hidden" name="id" value="{{ $work->id }}">
                    @else
                        <input type="hidden" name="id" value="">
                    @endif
                        
                        <input type="hidden" name="target_date"  value="{{ $date }}">
                </form>
            </div>
        </div>
    </div>
</body>
@endsection