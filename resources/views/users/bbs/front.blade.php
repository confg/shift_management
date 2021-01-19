@extends('layouts.work_schedule')
@section('title', '掲示板タイトル')

@section('content')
  <div  class="container">
    <div>
      <div>
        <div>
          <h1>名前</h1>
          <h3>{{ $bbs->user->name }}</h3>
        </div>
        
        <hr color="#c0c0c0">
        <div>
          <h1>タイトル</h1>
          <h3>{{ $bbs->title }}</h3>
        </div>
        
        <hr color="#c0c0c0">
        <div>
          <h1>本文</h1>
          <h3>{{ $bbs->body }}</h3>
        </div>
        
      </div>
    </div>
</div>


@endsection