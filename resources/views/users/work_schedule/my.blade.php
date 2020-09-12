@extends('layouts.work_schedule')

@section('content')
    <body>
        <h1>自分の勤務表</h1>
        <h2>{{ $currentYear.'年'.$currentMonth.'月' }}</h2>
        
        <a>前月</a>
        <a href="{{ action('Users\WorkScheduleController@next', ['currentYear' => $currentYear, 'currentMonth' => $currentMonth ]) }}">翌月</a>
        <table>
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
         
            <tr>
            <?php $cnt = 0; ?>    
            @foreach ($dates as $key => $value)
         
                <td>
                <?php $cnt++; ?>
                <a href ="{{ action('Users\WorkScheduleController@date', [ 'currentMonth' => $currentMonth, 'currentDay' => $value['day'] ]) }}" >{{ $value['day'] }}</a>
                </td>
            
                @if ($cnt == 7)
                </tr>
                <tr>
                <?php $cnt = 0; ?>    
                @endif
         
            @endforeach
            </tr>
        </table>
        
    </body>
@endsection