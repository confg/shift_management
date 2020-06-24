@extends('layouts.users')
@section('title', '登録済みの掲示板一覧')

@section('content')

    <div class="container">
        <h1>掲示板一覧<h1>
        <div>
            <a href="{{ action('Users\BbsController@create') }}">新規作成</a>
        </div>
        
    </div>
@endsection
    </div>