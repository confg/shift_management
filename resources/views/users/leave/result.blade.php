@extends('layouts.work_schedule')

@section('content')
<body>
    <h1>結果</h1>
    <table>
        <tr>
            <th>申請日</th>
            <th>希望日</th>
            <th>認可</th>
            <th>拒否の理由など</th>
        </tr>
        @foreach($leave as $result)
        <tr>
            <td>{{ $result->created_at->format('Y年m月d日')  }}</td>
            <td>{{ date('Y年m月d日',  strtotime($result->date)) }}</td>
            
            @if($result->permit == true)
                <td>{{ config('const.PERMIT') }}</td>
            @elseif($result->permit == false)
                <td>{{ config('const.BLOCKING') }}</td>
            @endif
            
            <td></td>
        </tr>
        @endforeach
    </table>    
</body>
@endsection