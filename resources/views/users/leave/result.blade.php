@extends('layouts.work_schedule')

@section('content')
<body>
    <div class="width">
        <div class="container">
            <h1>休暇申請結果</h1>
        </div>
        
        <table>
            
            <tr>
                <th width="20%">申請日</th>
                <th width="20%">希望日付</th>
                <th width="10%">申請結果</th>
                <th class="wordbreake" width="60%">コメント</th>
                
            </tr>
            @foreach($leave as $result)
            <tr>
                <td>{{ date('Y年m月d日',  strtotime($result->created_at)) }}</td>
                <td>{{ date('Y年m月d日',  strtotime($result->date)) }}</td>
                
                @if($result->permit == true)
                    <td>{{ config('const.PERMIT') }}</td>
                @elseif($result->permit == false)
                    <td>{{ config('const.BLOCKING') }}</td>
                @endif
                
                <td>{{ $result->comment }}</td>
                
            </tr>
            
            @endforeach
        </table>
    </div>    
</body>
@endsection