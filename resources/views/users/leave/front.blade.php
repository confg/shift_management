@extends('layouts.work_schedule')

@section('content')
<body>
    <h1>test</h1>
    <form action="{{ action('Users\LeaveController@update') }}" method="post">
        <tr>
            <td>{{ $tests->user->name }}</td>
        　　<td>{{ date('Y年m月d日',  strtotime($tests->date)) }}</td>
        　　<td>{{ $tests->leaveReasonMaster->reason_name }}</td>
        　　<td>{{ $tests->text }}</td>
    　　</tr>
    　　<input type="submit" name="permit" value="承認"/>
    　　<input type="submit" name="blocking" value="却下"/>
    　　{{ csrf_field() }}
    　　<input type="hidden" name="id" value="{{ $tests->id }}"/>
    </form>
</body>
@endsection