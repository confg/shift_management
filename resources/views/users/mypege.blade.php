@extends('layouts.base')

@section('content')
<body>
    <div class="container">
        <div>
            <div class="info">
                @can('admin')
                <a href="{{ url('/register') }}">Register</a>
                @endcan
            </div>
            <h1>マイページ</h1>
            <div class="content">
                <div class="content-left">
                    <div class="buttom-bule">
                        <a class="block" href="{{ action('Users\BbsController@index') }}">掲示板</a>
                    </div>
                    <div class="buttom-bule">
                        <a class="block" href="{{ action('Users\WorkScheduleController@add') }}">自分の勤務表</a>
                    </div>
                    @can('user')
                    <div class="buttom-bule">
                        <a class="block" href="{{ action('Users\LeaveController@leave') }}">休暇申請</a>
                    </div>
                    <div class="buttom-bule">
                        <a class="block" href="{{ action('Users\LeaveController@result') }}">休暇申請結果</a>
                    </div>
                    @endcan
                    @can('admin')
                    <div class="buttom-bule">
                        <a class="block" href="{{ action('Users\WorkScheduleController@whole') }}">全体の勤務表</a>
                    </div>
                    <div class="buttom-bule">
                        <a class="block" href="{{ action('Users\LeaveController@management') }}">休暇申請受け取り先</a>
                    </div>
                    @endcan
                    
                </div>
                
                <div class="content-right">
                    <h3>プロフィール</h3>
                    <table>
                        
                      <tr>
                        <th>名前</th><td>{{ $user->name }}</td>
                      </tr>
                      <tr>
                        <th>メールアドレス</th><td>{{ $user->email }}</td>
                      </tr>
                      
                    </table>
                </div>
            </div>    
        </div>
    </div>
</body>
@endsection
