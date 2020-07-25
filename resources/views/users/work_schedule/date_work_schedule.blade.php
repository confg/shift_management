<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>日付のページ</title>
</head>
<body>
    <h1>日付のページ</h1>
    <div>
        <div>
            <div>
                <form action="{{ action('Users\WorkScheduleController@update') }}" method="post">
                    <div>
                        <p>予定出勤時間</p>
                        <input type="time" min="0:00" max="23:59" required　name="start" value="{{ old('time') }}">
                    </div>
                    
                    <div>
                        <p>予定退勤時間</p>
                        <input type="time" min="0:00" max="23:59" required name="" value="{{ old('endtime') }}">
                    </div>
                    
                    <div>
                        <p>実働出勤時間
                        <select  disabled="disabled">
                            <option value="one">0時</option>
                            <option value="">1時</option>
                            <option value="">2時</option>
                            <option value="">3時</option>
                            <option value="">4時</option>
                            <option value="">5時</option>
                            <option value="">6時</option>
                            <option value="">7時</option>
                            <option value="">8時</option>
                            <option value="">9時</option>
                            <option value="">10時</option>
                            <option value="">11時</option>
                            <option value="">12時</option>
                            <option value="">13時</option>
                            <option value="">14時</option>
                            <option value="">15時</option>
                            <option value="">16時</option>
                            <option value="">17時</option>
                            <option value="">18時</option>
                            <option value="">19時</option>
                            <option value="">20時</option>
                            <option value="">21時</option>
                            <option value="">22時</option>
                            <option value="">23時</option>
                        </select>
                        <select  disabled="disabled">
                            <option value="one">00</option>
                            <option value="">30</option>
                        </select></p>
                    </div>
                    
                    <div>
                        <p>実働退社時間
                        <select  disabled="disabled">
                            <option value="one">0時</option>
                            <option value="">1時</option>
                            <option value="">2時</option>
                            <option value="">3時</option>
                            <option value="">4時</option>
                            <option value="">5時</option>
                            <option value="">6時</option>
                            <option value="">7時</option>
                            <option value="">8時</option>
                            <option value="">9時</option>
                            <option value="">10時</option>
                            <option value="">11時</option>
                            <option value="">12時</option>
                            <option value="">13時</option>
                            <option value="">14時</option>
                            <option value="">15時</option>
                            <option value="">16時</option>
                            <option value="">17時</option>
                            <option value="">18時</option>
                            <option value="">19時</option>
                            <option value="">20時</option>
                            <option value="">21時</option>
                            <option value="">22時</option>
                            <option value="">23時</option>
                        </select>
                        <select  disabled="disabled">
                            <option value="one">00</option>
                            <option value="">30</option>
                        </select></p>
                        {{ csrf_field() }}
                        <div>
                            
                            <div>
                                <input type="submit" value="更新">
                            </div>
                        </div>
                        @if ( $work != null )
                          <input type="hidden" name="id" value="{{ $work->id }}">
                        @else
                          <input type="hidden" name="id" value="">
                        @endif
                        
                        <input type="hidden" name="date"  value="{{ $date }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>