@extends('layouts.work_schedule')

@section('content')

<body>
    <h1>自分の勤務表</h1>
    <h2>{{ $currentYear.'年'.$currentMonth.'月' }}</h2>
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
@endsection