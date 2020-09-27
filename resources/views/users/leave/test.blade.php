<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>test</h1>
    <form action="{{ action('Users\WorkScheduleController@application') }}" method="post">
        <tr>
            <input type="text" name="user_id" value="{{ $tests->user->name }}">
        　　<input type="date" name="date" value="{{ $tests->date }}">
        　　<input type="text" name="item" value="{{ $tests->item }}">
        　　<input type="text" name="text" value="{{ $tests->text }}">
    　　</tr>
    　　<input type="submit" name="permit" value="許可"/>
    　　<input type="submit" name="blocking" value="拒否"/>
    　　{{ csrf_field() }}
    </form>
</body>
</html>