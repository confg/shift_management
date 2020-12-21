@extends('layouts.work_schedule')
@section('title', '登録済みの掲示板一覧')

@section('content')

   
    <div class="container">
        <h1>掲示板一覧<h1>
    </div>
    
    <div class="container">
        <div class="wrap">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{ action('Users\BbsController@formcreate') }}" role="button" class="btn btn-primary">新規作成</a>
                </div>
                <div class="col-md-8">
                    <form action="{{ action('Users\BbsController@index')}}" method="get">
                        <div class="form-group row">
                            <label class="col-md-2">掲載者</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-2">タイトル</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                            </div>
                            <select name="sort">
                                <option value="asc" {{ $selected1 }}>昇順</option>
                                <option value="desc" {{ $selected2 }} >降順</option>
                            </select>
                            <div class="col-md-2">
                                {{ csrf_field() }}
                                <input type="submit" class="btn btn-primary" value="検索">
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>    
        <div class="wrap">
            <table>
                <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>本文</th>
                        <th>掲載日</th>
                        <th>掲載者</th>
                        @can('admin')
                        <th>操作</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $bbs)
                        <div class="widelink">
                            
                            <tr>
                                
                               <td><a href="{{ action('Users\BbsController@front', ['id' => $bbs->id]) }}">{{ \Illuminate\Support\Str::limit($bbs->title, 20) }}</a></td>
                               <td>{{ \Illuminate\Support\Str::limit($bbs->body, 20) }}</td>
                               <td>{{ date('Y年m月d日',  strtotime($bbs->posted_at)) }}</td>
                               <td>{{ $bbs->user->name }}</td>
                               @can('admin')
                               <td>
                                    <div>
                                        <a href="{{ action('Users\BbsController@edit', ['id' => $bbs->id]) }}">更新</a>
                                    </div>
                                    <div>
                                        <a href="{{ action('Users\BbsController@delete', ['id' => $bbs->id]) }}">削除</a>
                                    </div>
                                </td>
                                @endcan
                            </tr>
                            
                        </div>
                    @endforeach
                </tbody>
            </table>
            
            <div class="next">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection