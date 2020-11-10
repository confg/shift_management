@extends('layouts.work_schedule')

@section('content')
<body>
    <div class="container">
        <h1 class="title">休暇申請</h1>
    </div>
    
    <div class="container">
        <div>
            <form action="{{ action('Users\LeaveController@application') }}" method="post">
                <div class="content">
                    <div class="contents">
                        <h4 class="plan-contents">氏名</h4>
                        <div class="plan-contents">
                            {{ $user }}
                        </div>
                    </div>
                    
                    <div class="contens">
                        <h4 class="plan-contents" for="suggested_time">希望日付</h4>
                        <div>
                            <input class="date" type="date" name="date" min="2020-01-01" max="2030-01-01" required/>
                        </div>
                    </div>
                    
                    <div  class="plan-contents">
                        @foreach($all as $alls)
                        <input name="leave_reason_master_id" type="radio" value="{{ $alls->id }}" required/>{{ $alls->reason_name }}
                        @endforeach
                    </div>
                    
                    <div class="plan-contents">
                        <h4>備考・理由</h4>
                        <textarea class="text" name="text"></textarea>
                    </div>
                    <input class="buttom date" type="submit" value='送信'/>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</body>
@endsection
