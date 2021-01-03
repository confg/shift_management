@extends('layouts.work_schedule')

@section('content')
<body>
    <div>
        
        <div class="width">
            <h1>全体の勤務表</h1>
            <h2>{{ $date }}</h2>
            <form action="{{ action('Users\WorkScheduleController@whole') }}" method="get">
                <input type="date" name="target_date" value="target_date"/>
                
                
                <input type="submit" value="送信"/>
                
                {{ csrf_field() }}
            </form>
            
            <div>
                <div>
                    <table>
                        <thead>
                            
                            <tr>
                                <th>状態</th>
                                <th>名前</th>
                                <th>出勤予定時間</th>
                                <th>退社予定時間</th>
                                <th>出勤</th>
                                <th>退勤</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($result as $status)
                            
                            <tr>
                                @if($status->attendance != '00:00:00' && $status->leaving == '00:00:00')
                                    <td>勤務中</td>
                                @else
                                    <td>勤務時間外</td>
                                @endif
                             　 <td>{{ $status->username }}</td>
                                <td>{{ date('G時i分',  strtotime($status->starttime)) }}</td>
                                <td>
                                    @if($status->date_borders == 'next_day')
                                        {{ config('const.NEXT_DAY') }}
                                    @endif
                                    {{ date('G時i分',  strtotime($status->endtime)) }}
                                    </td>
                                <td>{{ date('G時i分',  strtotime($status->attendance)) }}</td>
                                <td>
                                    @if($date < date("m月d日",strtotime($status->leaving_date)) )
                                        {{ config('const.NEXT_DAY') }}
                                    @endif
                                    {{ date('G時i分',  strtotime($status->leaving)) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
