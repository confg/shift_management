<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Bbs;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BbsController extends Controller
{
    
    
    public function formcreate()
    {
      
      return view('users.bbs.create');
      
    }
    
    public function create(Request $request)
    {
     
      $this->validate($request, Bbs::$rules);
      
      $bbs = new Bbs;
      $form = $request->all();
      
      
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $bbs->image_path = basename($path);
      } else {
          $bbs->image_path = null;
      }
      
      unset($form['_token']);
      
      unset($form['image']);
      
      
      $bbs->posted_at = Carbon::now();
      
      
      $bbs->user_id = Auth::id();
      
      
      $bbs->fill($form);
      $bbs->save();
      
      
      return redirect('users/bbs/index');
      
    }
    
    
    
    public function index(Request $request) {
      
      $posts = Bbs::orderBy('id', 'desc')->simplePaginate(10);
      
      //掲載者のソート機能
      $sort = $request->sort;
      if ($sort == 'asc') {
        $posts = Bbs::orderBy('posted_at', 'asc')->simplePaginate(10);
      }elseif($sort == 'desc') {
        $posts = Bbs::orderBy('posted_at', 'desc')->simplePaginate(10);
      }
      
      
      $cond_title = $request->cond_title;
      if($sort == 'asc' && $cond_title != '') {
        $posts = Bbs::where('title', $cond_title)
        ->orderBy('posted_at', 'asc')
        ->simplePaginate(10);
      }elseif($sort == 'desc' && $cond_title != '') {
        $posts = Bbs::where('title', $cond_title)
        ->orderBy('posted_at', 'desc')
        ->simplePaginate(10);
      }
      
      
      /*
      //名前の検索がuser_idだったらできる状態
      $cond_name = $request->cond_name;
      if($sort == 'asc' && $cond_name != '') {
        $posts = Bbs::where('user_id', $cond_name)
        ->orderBy('posted_at', 'asc')
        ->simplePaginate(10);
      }elseif($sort == 'desc' && $cond_name != '') {
        $posts = Bbs::where('user_id', $cond_name)
        ->orderBy('posted_at', 'desc')
        ->simplePaginate(10);
      }
      */
      
      $cond_name = $request->cond_name;
      if($sort == 'asc' && $cond_name != '') {
        $user = User::where('name', $cond_name)->simplePaginate(10);
        $posts = $user->bbs;
        
      }elseif($sort == 'desc' && $cond_name != '') {
        $user = User::where('name', $cond_name)->simplePaginate(10);
        $posts = $user->bbs;
        
      }
      
      
      var_dump($sort);
      
      return view('users.bbs.index', ['posts' => $posts, 'cond_title' => $cond_title, 'cond_name' => $cond_name ]);
      
    }
    
    
    public function edit(Request $request) {
      
      $bbs = Bbs::find($request->id);
      if (empty($bbs)) {
        abort(404);    
      }
      return view('users.bbs.edit', ['bbs_form' => $bbs]);
    }
    
    public function update(Request $request) {
      
      $this->validate($request, Bbs::$rules);

      $bbs = Bbs::find($request->id);

      $bbs_form = $request->all();
      if (isset($bbs_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $bbs->image_path = basename($path);
        unset($bbs_form['image']);
      } elseif (isset($request->remove)) {
        $bbs->image_path = null;
        unset($bbs_form['remove']);
      }
      unset($bbs_form['_token']);
      
      $bbs->fill($bbs_form)->save();
      
      
      
      return redirect('users/bbs/index');
    }
    
    public function delete(Request $request)
    {
      
      $bbs = Bbs::find($request->id);

      $bbs->delete();
      return redirect('users/bbs/index');
    }
    
    
    
    
    public function front(Request $request) {
      
      $bbs = Bbs::find($request->id);
      
      
      
      return view('users.bbs.front', ['bbs' => $bbs]);
    }
    
    //名前をとるメソッド
    public function getUserName($user_id) {
      $username = DB::table('users')
      ->select('name')
      ->where('id',$user_id)
      ->get();
      
      return $username->name;
    }
    
 }
