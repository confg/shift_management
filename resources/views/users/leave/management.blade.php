@extends('layouts.work_schedule')

@section('content')
<body>
    <div class="width">
        <h1>休暇申請の一覧</h1>
        <div class="wrap">
            <form action="{{ action('Users\LeaveController@management') }}" method="get">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label class="col-md-4">氏名</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">未返答の検索</label>
                            <select class="select-box" name="reply">
                                <option value="">---</option>
                                <option value="post" {{ $selected3 }}>未返答</option>
                            </select>
                            <select class="select-box-right" name="sort">
                                <option value="asc" {{ $selected1 }}>昇順</option>
                                <option value="desc" {{ $selected2 }} >降順</option>
                            </select>
                            <div class="col-md-2">
                                {{ csrf_field() }}
                                <input type="submit" class="btn btn-primary" value="検索">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>      
        <table>
            <tr>
                <th width="20%">氏名</th>
                <th width="20%">希望日付</th>
                <th width="20%">有給・その他</th>
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
            {{ $manage->appends(request()->query())->links() }}
        </div>
    </div>
</body>
@endsection