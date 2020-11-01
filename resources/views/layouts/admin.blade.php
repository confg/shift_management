<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title')</title>
        
        <script src="{{ secure_asset('js/app.js') }}" defer></script>
        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/work.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div>
            <div class="topper">
                
                <a href="{{ action('Users\UserController@add') }}">マイページ</a>
                <a href="{{ action('Users\BbsController@index') }}">掲示板</a>
                <a href="{{ action('Users\WorkScheduleController@add') }}">自分の勤務表</a>
                @can('user')
                    <a href="{{ action('Users\LeaveController@leave') }}">休暇申請</a>
                    <a href="{{ action('Users\LeaveController@result') }}">休暇申請結果</a>
                @endcan
                
                @can('admin')
                    <a href="{{ action('Users\WorkScheduleController@whole') }}">全体の勤務表</a>
                    <a href="{{ action('Users\LeaveController@management') }}">休暇申請受け取り先</a>
                @endcan
                
            </div>
            <main class="py-4">
                {{-- コンテンツをここに入れるため、@yieldで空けておきます。 --}}
                @yield('content')
            </main>
        </div>
    </body>
</html>