@extends('layouts.work_schedule')

@section('content')
<body>
    
    <div class="width">
        <h1>勤務表の各日付</h1>
        <div class="content">
            
            <div class="content-left">
                
                <table class="table">
                    <tr>
                        <td>
                            <h2>{{ $selectMonth.'月'.$selectDay.'日' }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <form action="{{ action('Users\WorkScheduleController@attendance', [ 'id' => $work ]) }}" method="post">
                                {{ csrf_field() }}
                                
                                @if( date("Y-m-j") == $date && $work->leaving == '00:00:00')
                                    @if($work->attendance == '00:00:00')
                                        <input class="button" type="submit" name="attendance" value="出勤"/>
                                    @else
                                        <input class="button" type="submit" name="leaving" value="退勤"/>
                                    @endif
                                @endif
                            </form>
                        </td>
                    </tr>
                    
                    <form action="{{ action('Users\WorkScheduleController@update') }}" method="post">
                        <tr>
                            <div class="contents">
                                <td>
                                    <h5>出勤予定時間</h5>
                                    <input class="button" type="time" min="0:00" max="23:59" required name="starttime" value="{{ old('starttime') }}">
                                </td>
                                <td>
                                    <h5>退勤予定時間</h5>
                                    <input class="button" type="time" min="0:00" max="23:59" required name="endtime" value="{{ old('endtime') }}">
                                </td>
                                <td>
                                    <select name="date_borders">
                                        <option value='today'>{{ config('const.TODAY') }}</option>
                                        <option value='next_day'>{{ config('const.NEXT_DAY') }}</option>
                                    </select>  
                                </td>
                            </div>
                        </tr>
                        <tr>
                            @if( $work->starttime == null )
                                <td>
                                    <input class="button" type="submit" value="登録">
                                </td>
                            @endif
                            @if( $work->starttime != '00:00:00' && $work->starttime != null )
                                <td>
                                    <input class="button" type="submit" value="更新">
                                </td>
                            @endif
                        </tr>
                        @if ( $work != null )
                            <input type="hidden" name="id" value="{{ $work->id }}">
                        @else
                            <input type="hidden" name="id" value="">
                        @endif
                        <input type="hidden" name="target_date"  value="{{ $date }}">
                        {{ csrf_field() }}
                    </form>
                </table>
            </div>
            <div class="content-right">
                <table class="table">
                    <tr>
                        <td>
                            <h2>{{ $selectMonth.'月'.$selectDay.'日の予定' }}</h2>
                           
                        </td>    
                    </tr>
                    <tr>
                        <td>
                            @if($work->starttime != null && $work->endtime != null)
                                <h3>{{ date('G時i分',  strtotime($work->starttime)) }}から
                                @if($work->date_borders == 'next_day')
                                    {{ config('const.NEXT_DAY') }}
                                @endif
                                {{date('G時i分',  strtotime($work->endtime))."まで" }}</h3>
                            @else
                                <h2>未入力</h2>
                            @endif
                        </td>    
                    </tr>
                </table>
            </div>
        </div>    
    </div>
    
</body>
@endsection