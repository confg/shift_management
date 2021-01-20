<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            
            .full-height {
                height: 100vh;
            }
            
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            
            .position-ref {
                position: relative;
            }
            
            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }
            
            .m-b-md {
                margin-bottom: 80px;
            }
            
            a {
                color: #fff;
                text-decoration: none;
            }
            
            a:hover {
                color: #c0c0c0;
                text-decoration: none;
            }
            
            .block {
                border: 2px solid #000066; 
                background: #4169e1;
                display: block;
                width: 250px;
                margin: 0 25px;
                padding: 10px;
                text-align: center;
                border-radius: 10px;
                line-height: 1em;
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            

            <div class="content">
                <div class="title m-b-md">
                    勤怠管理アプリ
                </div>
                
                @if (Route::has('login'))
                    <div class="flex-center">
                        <a class="block" href="{{ url('/login') }}">ログイン</a>
                        <a class="block" href="{{ url('/register') }}">新規登録</a>
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>