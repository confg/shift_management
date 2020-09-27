@extends('layouts.work_schedule')

@section('content')
<body>
    <h1>休暇申請</h1>
    <div class="container">
        <div class="">
            <form action="{{ action('Users\WorkScheduleController@application') }}" method="post">
                <div class="content">
                    <div class="content-item">
                        <label>氏名</label>
                        <div>
                            {{ $user }}
                        </div>
                    </div>
                    
                    <div class="content-item">
                        <label for="suggested_time">希望日付</label>
                        <div>
                            <input type="date" name="date" min="2020-01-01" max="2030-01-01" required/>
                        </div>
                    </div>
                    <div class="radio-button">
                        <input name="item" type="radio" value="1" required/>有給
                        <input name="item" type="radio" value="2" required/>その他
                    </div>
                    <div class="">
                        <label>備考・理由</label>
                        <textarea name="text"></textarea>
                    </div>
                    <input type="submit" value='送信'/>
                </div>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</body>
@endsection
