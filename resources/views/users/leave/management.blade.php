@extends('layouts.work_schedule')

@section('content')
<body>
    <div class="width">
        <h1>休暇申請の一覧</h1>
        <form action="{{ action('Users\LeaveController@management') }}" method="get">
            <div class="form-group row">
                
                
                <select name="sort">
                    <option value="asc">昇順</option>
                    <option value="desc">降順</option>
                </select>
                
                <select name="reply">
                    <option value="">---</option>
                    <option value="post">未返答</option>
                </select>
                
                
                <div class="col-md-2">
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="検索">
                </div>
            </div>
            
        </form>
        <table>
            <tr>
                <th width="20%" >氏名</th>
                <th width="20%" >希望日付</th>
                <th width="10%" >有給・その他</th>
                <th>備考・理由</th>
                <th>返答済み</th>
            </tr>
            @foreach($manage as $test)
            <tr>
                @if(isset($test->permit))
                    <td>{{ $test->user->name }}</td>
                @else
                    <td><a href="{{ action('Users\LeaveController@front', [ 'id' => $test->id ]) }}">{{ $test->user->name }}</a></td>
                @endif
                
                <td>{{ date('Y年m月d日',  strtotime($test->date)) }}</td>
                <td>{{ $test->leaveReasonMaster->reason_name }}</td>
                <td >{{ \Illuminate\Support\Str::limit($test->text,20) }}</td>
                @if(isset($test->permit))
                    <td>返答済み</td>
                @else
                    <td>未返答︎︎</td>
                @endif
            </tr>
            @endforeach
        </table>
        <div class="next">
            {{ $manage->links() }}
        </div>
    </div>
</body>
@endsection