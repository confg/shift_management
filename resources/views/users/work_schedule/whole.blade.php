@extends('layouts.work_schedule')

@section('content')
<body>
    
    <div>
        <div>
            <form action="{{ action('Users\WorkScheduleController@whole') }}" method="get">
                <input type="date" name="target_date" value="target_date"/>
                
                <input type="submit" value="Submit"/>
                {{ csrf_field() }}
            </form>
            <div>
                <div>
                    <h1>{{ $date }}</h1>
                    <table>
                        <thead>
                            
                            <tr>
                                <th>状態</th>
                                <th>氏名</th>
                                <th>出勤時間</th>
                                <th>退社予定時間</th>
                                <th>出勤</th>
                                <th>退勤</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($result as $status)
                            
                            <tr>
                                @if($status->attendance != '00:00:00')
                                    <td>勤務中</td>
                                @else
                                    <td>勤務時間外</td>
                                @endif
                             　 <td>{{ $status->username }}</td>
                                <td>{{ date('H時i分',  strtotime($status->starttime)) }}</td>
                                <td>{{ date('H時i分',  strtotime($status->endtime)) }}</td>
                                <td>{{ $status->attendance }}</td>
                                <td>{{ $status->leaving }}</td>
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
