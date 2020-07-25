<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <title>自分の勤務表</title>
</head>
<body>
    <h1>自分の勤務表</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
              @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
              <th>{{ $dayOfWeek }}</th>
              @endforeach
            </tr>
        </thead>
        <tbody>
            
            @foreach ($dates as $date)
            @if ($date->dayOfWeek == 0)
                
                <tr>
                @endif
                  
                  <td
                    @if ($date->month != $currentMonth)
                    class="bg-secondary"
                    @endif
                    >
                    <a href="{{ action('Users\WorkScheduleController@date', ['currentYear' => $currentYear, 'currentMonth' => $currentMonth, 'currentDay' => $date->day]) }}">
                    {{ $date->day }}
                    </a>
                  </td>
                  
                @if ($date->dayOfWeek == 6)
                </tr>
                
            @endif
            @endforeach
            
        </tbody>
    </table>
</body>
</html>