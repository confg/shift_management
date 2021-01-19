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
                            <label class="col-md-4">申請日</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="application_date" value="{{ $application_date }}">
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
                                    <option value="">選択なし</option>
                                    @foreach($leave_type as $alls)
                                        <option name="leave_reason_master_id" value="{{ $alls->id }}" {{ (string)$alls->id == $leave_reason_master_id ? 'selected' : '' }}>{{ $alls->reason_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4" style="padding-top:10px">未返答の検索</label>
                            <input type="checkbox" class="select-box" name="reply" value="post" {{ $selected5 }} style="transform:scale(2.0);margin:15px;">
                            
                            <select style="margin-left:70px"  name="sort_order">
                                <option value="created_at" {{ $selected['created_at'] ? 'selected' : '' }}>申請日順</option>
                                <option value="date" {{ $selected['suggested_date'] ? 'selected' : '' }} >希望日付順</option>
                                <option value="user_id" {{ $selected['user_name'] ? 'selected' : '' }} >名前順</option>
                            </select>
                            
                            <select style="margin-left:23px" name="sort">
                                <option value="desc" {{ $sort1['desc'] ? 'selected' : '' }} >降順</option>
                                <option value="asc" {{ $sort1['asc'] ? 'selected' : '' }}>昇順</option>
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
                <th>申請日</th>
                <th>名前</th>
                <th>希望日付</th>
                <th>有給・その他</th>
                <th>備考・理由</th>
                <th>返答済み</th>
            </tr>
            @foreach($manage as $test)
            <tr>
                <td>{{ date('Y年n月j日',  strtotime($test->created_at)) }}</td>
                @if(isset($test->permit))
                    <td>{{ $test->user->name }}</td>
                @else
                    <td><a href="{{ action('Users\LeaveController@front', [ 'id' => $test->id ]) }}">{{ $test->user->name }}</a></td>
                @endif
                
                <td>{{ date('Y年n月j日',  strtotime($test->date)) }}</td>
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
        {{ $manage->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}
    </div>
</body>
@endsection