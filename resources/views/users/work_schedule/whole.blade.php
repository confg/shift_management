@extends('layouts.work_schedule')

@section('content')
<body>
    <div class="">
        <div class="">
            <h1>{{ $date }}</h1>
            <div class="">
                
            </div>
            <div class="">
                <div class="">
                    <table>
                        <thead>
                            <tr>
                                <th>状態</th>
                                <th>氏名</th>
                                <th>出勤時間</th>
                                <th>退社予定時間</th>
                                <th>残業</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $status)
                            
                            <tr>
                                <td>a</td>
                             　 <td>{{ $status->username }}</td>
                                <td>{{ date('H時i分',  strtotime($status->starttime)) }}</td>
                                <td>{{ date('H時i分',  strtotime($status->endtime)) }}</td>
                                <td></td>
                                
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
