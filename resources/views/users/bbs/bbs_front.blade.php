@extends('layouts.users')
@section('title', 'ニュースの新規作成')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>掲示板の各ページ</h2>
                <form action="{{ action('Users\BbsController@front') }}" method="post" enctype="multipart/form-data">

                    
                </form>
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
                            {{ $date->day }}
                          </td>
                        @if ($date->dayOfWeek == 6)
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
    
                
                
            </div>
        </div>
    </div>
@endsection