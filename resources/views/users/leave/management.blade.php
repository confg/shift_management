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
                            <label class="col-md-4">名前</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-4">希望日付</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="suggested_date" value="{{ $suggested_date }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">備考・理由</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cause" value="{{ $cause }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">有給・その他</label>
                            <div>
                                <select class="select-box" style="width:120px;height:37px" name="leave_reason_master_id">
                                    <option value="" selected>選択なし</option>
                                    @foreach($leave_type as $alls)
                                        <option name="leave_reason_master_id" value="{{ $alls->id }}">{{ $alls->reason_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4" style="padding-top:10px">未返答の検索</label>
                            <input type="checkbox" class="select-box" name="reply" value="post" {{ $selected6 }} style="transform:scale(2.0);margin:15px;">
                            <select style="margin-left:70px"  name="sort_order">
                                <option value="date" {{ $selected1 }} >希望日付</option>
                                <option value="user_id" {{ $selected2 }} >名前</option>
                                <option value="text" {{ $selected3 }}>備考・理由</option>
                            </select>
                            <select style="margin-left:23px" name="sort">
                                <option value="desc" {{ $selected4 }} >降順</option>
                                <option value="asc" {{ $selected5 }}>昇順</option>
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
                <th width="20%">名前</th>
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