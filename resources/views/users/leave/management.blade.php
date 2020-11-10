@extends('layouts.work_schedule')

@section('content')
<body>
    <div class="width">
        <h1>休暇申請受け取り先</h1>
        
        <table>
            <tr>
                <th>氏名</th>
                <th>希望日付</th>
                <th>有給・その他</th>
                <th>備考・理由</th>
            </tr>
            @foreach($manage as $test)
            <tr>
                <td><a href="{{ action('Users\LeaveController@front', [ 'id' => $test->id ]) }}">{{ $test->user->name }}</a></td>
                <td>{{ date('Y年m月d日',  strtotime($test->date)) }}</td>
                <td>{{ $test->leaveReasonMaster->reason_name }}</td>
                <td>{{ $test->text }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
@endsection