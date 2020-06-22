<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>マイページ</title>
</head>
<body>
    <h1>マイページ</h1>
    <div class="container">
        <div class="content">
            <div class="info">
                
            </div>
            
            <div class="content-left">
                
                <div class="buttom-bule">
                    <a href="{{ action('Users\WorkScheduleController@add') }}">自分の勤務表</a>
                </div>
                <div class="buttom-bule">
                    <a href="{{ action('Users\WorkScheduleController@whole') }}">全体の勤務表</a>
                </div>
                <div class="buttom-bule">
                    <a href="{{ action('Users\BbsController@add') }}">掲示板</a>
                </div>
                <div class="buttom-bule">
                    <a href="{{ action('Users\WorkScheduleController@leave') }}">休暇申請</a>
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
</html>