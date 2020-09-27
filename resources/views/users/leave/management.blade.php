<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    
　　<table>
　　     <tr>
　　        <td>氏名</td>
　　        <td>日付</td>
　　        <td></td>
　　        <td>備考・理由</td>
　　     </tr>
　　     @foreach($manage as $test)
　　     <tr>
　　        <td><a href="{{ action('Users\WorkScheduleController@test',[ 'id' => $test->id ]) }}">{{ $test->user->name }}</a></td>
　　        <td>{{ $test->date }}</td>
　　        <td>{{ $test->item }}</td>
　　        <td>{{ $test->text }}</td>
　　     </tr>
　　     @endforeach
　　     
　　    
　　     
　　</table>
　　
</body>
</html>