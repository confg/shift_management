@extends('layouts.work_schedule')

@section('content')
    <body>
        <div class="width">
            <h1>自分の勤務表</h1>
            <h2>{{ $currentYear.'年'.$currentMonth.'月' }}</h2>
            <div>
                <a class="month" href="{{ action('Users\WorkScheduleController@monthmove', ['currentYear' => $currentYear, 'currentMonth' => $currentMonth, 'mode' => '-1' ]) }}"><前月</a>
                <a class="month" href="{{ action('Users\WorkScheduleController@monthmove', ['currentYear' => $currentYear, 'currentMonth' => $currentMonth, 'mode' => '+1' ]) }}">翌月></a>
            </div>    
            <table>
                <tr>
                    <th class="red">日</th>
                    <th class="blue">月</th>
                    <th class="blue">火</th>
                    <th class="blue">水</th>
                    <th class="blue">木</th>
                    <th class="blue">金</th>
                    <th class="green">土</th>
                </tr>
             
                <tr>
                <?php $cnt = 0; ?>    
                @foreach ($dates as $key => $value)
             
                    <td class="day">
                    <?php $cnt++; ?>
                    <a href ="{{ action('Users\WorkScheduleController@date', [ 'currentYear' => $currentYear, 'currentMonth' => $currentMonth, 'currentDay' => $value['day'] ]) }}" >{{ $value['day'] }}</a>
                    </td>
                
                    @if ($cnt == 7)
                    <tr>
                    <tr/>
                    <?php $cnt = 0; ?>    
                    @endif
             
                @endforeach
                </tr>
            </table>
        </div>
    </body>
@endsection