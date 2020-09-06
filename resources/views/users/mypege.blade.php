@extends('layouts.users')

@section('content')
<body>
    <div class="container">
        <div class="content">
            <div class="info">
                
            </div>
            <h1>マイページ</h1>
            <div class="content-left">
            
                <div class="buttom-bule">
                    <a href="{{ action('Users\WorkScheduleController@add') }}">自分の勤務表</a>
                </div>
                <div class="buttom-bule">
                    <a href="{{ action('Users\WorkScheduleController@whole') }}">全体の勤務表</a>
                </div>
                <div class="buttom-bule">
                    <a href="{{ action('Users\BbsController@index') }}">掲示板</a>
                </div>
                <div class="buttom-bule">
                    <a href="{{ action('Users\WorkScheduleController@leave') }}">休暇申請</a>
                </div>
                <div>
                    <a href="{{ action('Users\WorkScheduleController@sample') }}">sample</a>
                </div>
            </div>
            
            <div class="content-right">
                <thead>
                    <tr>
                    　<th>氏名</th>
                    　<th>電話番号</th>
                    　<th>メールアドレス</th>
                    　<th>所属・部署</th>
                    </tr>
                </thead>
            </div>
        </div>
    </div>
</body>
@endsection
