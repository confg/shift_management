@extends('layouts.work_schedule')

@section('content')
<body>
    <h1>休暇申請</h1>
    <div class="container">
        <div class="">
            <div class="content">
                <div class="content-item">
                    <label for="name">氏名</label>
                    <div>
                        
                    </div>
                </div>
                <div class="content-item">
                    <label for="post">役職</label>
                    <div>
                        
                    </div>
                </div>
                <div class="content-item">
                    <label for="suggested_time">希望日付</label>
                    <div>
                        
                    </div>
                </div>
                <div class="radio-button">
                    <input name="" type="radio" required/>有給
                    <input name="" type="radio"/>その他
                </div>
                <div class="">
                    <label for="">備考・理由</label>
                    <textarea class="" ></textarea>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
