<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    
    <script src="{{ secure_asset('js/app.js') }}" defer></script>
    
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/work.css') }}" rel="stylesheet">
    
    
    <div class="header-buttom">
        <a href="{{ action('Users\UserController@add') }}">マイページ</a>
    
        <a href="{{ action('Users\WorkScheduleController@add') }}">自分の勤務表</a>
    
        <a href="{{ action('Users\WorkScheduleController@whole') }}">全体の勤務表</a>
    
        <a href="{{ action('Users\BbsController@index') }}">掲示板</a>
    
        <a href="{{ action('Users\WorkScheduleController@leave') }}">休暇申請</a>
    
        <a href="{{ action('Users\WorkScheduleController@sample') }}">sample</a>
        
    </div>    
<body>
    @yield('content')
</body>
</html>