@extends('layouts.work_schedule')

@section('content')
<body>
    
    <div class="container">
        <h1>休暇申請</h1>
        
        <div>
            <form action="{{ action('Users\LeaveController@application') }}" method="post">
                <div>
                    <div class="contents">
                        <h4 class="plan-contents">名前</h4>
                        <div class="plan-contents">
                            <h4>{{ $user }}</h4>
                        </div>
                    </div>
                    
                    <div class="contens">
                        <h4 class="plan-contents" for="suggested_time">希望日付</h4>
                        <div>
                            <input style="margin-left:20px;width:170px" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" type="date" name="date" min="2020-01-01" max="2030-01-01" required/>
                        </div>
                        @if (count($errors) > 0)
                           <div style="width:40%" class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    
                    <div  class="plan-contents">
                        @foreach($all as $alls)
                        <input name="leave_reason_master_id" type="radio" value="{{ $alls->id }}" required/>{{ $alls->reason_name }}
                        @endforeach
                    </div>
                    
                    <div class="plan-contents">
                        <h4>備考・理由</h4>
                        <textarea class="text" maxlength='50' rows="3" name="text"></textarea>
                    </div>
                    <input class="button date" type="submit" value='送信'/>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</body>
@endsection
