@extends('layouts.work_schedule')
@section('title', '掲示板タイトル')

@section('content')
  <div  class="front">
    <div>
      <div>
        
        <div>
          <h1>名前</h1>
          <p>{{ \Illuminate\Support\Str::limit($bbs->user->name, 100) }}</p>
        </div>
        
        <hr color="#c0c0c0">
        <div>
          <h1>タイトル</h1>
          <p>{{ \Illuminate\Support\Str::limit($bbs->title, 100) }}</p>
        </div>
        
        <hr color="#c0c0c0">
        <div>
          <h1>本文</h1>
          <p>{{ \Illuminate\Support\Str::limit($bbs->body, 250) }}</p>
        </div>
        
      </div>
    </div>
</div>


@endsection