@extends('layouts.admin')

@section('content')
<body>
    <div class="width">
        <h1>test</h1>
        <form action="{{ action('Users\LeaveController@update') }}" method="post">
            <table>
                <tr class="tr">
                    <th>氏名</th><td>{{ $tests->user->name }}</td>
                </tr>
                <tr>
                    <th>希望日付</th><td>{{ date('Y年m月d日',  strtotime($tests->date)) }}</td>
                </tr>
                <tr>
                    <th>有給・その他</th><td>{{ $tests->leaveReasonMaster->reason_name }}</td>
                </tr>
                <tr>
                    <th>理由</th><td>{{ $tests->text }}</td>
                </tr>
                <tr>
                    <th>承認</th>
                    <td>
                　　      <input type="submit" name="permit" value="承認"/>
            　　          <input type="submit" name="blocking" value="却下"/>
                　　</td>
                </tr>
            　　{{ csrf_field() }}
            　　<input type="hidden" name="id" value="{{ $tests->id }}"/>
            </table>　　
        </form>
    </div>    
</body>
@endsection