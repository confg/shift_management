@extends('layouts.users')
@section('title', 'ニュースの新規作成')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>掲示板の各ページ</h2>
                <form action="{{ action('Users\BbsController@front') }}" method="post" enctype="multipart/form-data">

                    
                </form>
            </div>
        </div>
    </div>
@endsection