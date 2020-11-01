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
    
    <link href="{{ secure_asset('css/my.css') }}" rel="stylesheet" type="text/css">
    
    
    <div class="header">
        <div class="header-left">
            <div class="black">
                <a href="{{ action('Users\UserController@add') }}">マイページ</a>
            </div>
            
            <div class="black">
                <a href="{{ action('Users\BbsController@index') }}">掲示板</a>
            </div>
            <div class="black">
                <a href="{{ action('Users\WorkScheduleController@add') }}">自分の勤務表</a>
            </div>
            @can('user')
            <div class="black">
                <a href="{{ action('Users\LeaveController@leave') }}">休暇申請</a>
            </div>
            <div class="black">
                <a href="{{ action('Users\LeaveController@result') }}">休暇申請結果</a>
            </div>
            @endcan
            
            @can('admin')
            <div class="black">
                <a href="{{ action('Users\WorkScheduleController@whole') }}">全体の勤務表</a>
            </div>
            <div class="black">
                <a href="{{ action('Users\LeaveController@management') }}">休暇申請受け取り先</a>
            </div>
            @endcan
        </div>
        <ul class="header-right">
            
            @guest
                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
            @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            @endguest
            {{-- 以上までを追記 --}}
        </ul>
        
    </div>    
<body>
    @yield('content')
</body>
</html>