<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
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
      
      $sort = $request->sort;
      $posts = Bbs::orderBy('id', $sort)->simplePaginate(10);
      
      
      $cond_title = $request->cond_title;
      if($cond_title != '') {
        $posts = Bbs::where('title', $cond_title)
        ->orderBy('posted_at', $sort)
        ->simplePaginate(10);
      }
      
      $cond_name = $request->cond_name;
      if($cond_name != '') {
        $user = User::where('name', $cond_name)->first();
        $posts = $user->bbs()
        ->orderBy('posted_at', $sort)
        ->simplePaginate(10);
      }
      
      
      
      if($cond_name != '' && $cond_title != '') {
        $title = Bbs::where('title', $cond_title)
        ->orderBy('posted_at', $sort)
        ->simplePaginate(10);
        $user = User::where('name', $cond_name)->first();
        $name = $user->bbs()
        ->orderBy('posted_at', $sort)
        ->simplePaginate(10);
        
        if($title && $name) {
          $name = $name->id;
          $title = $title->id;
          
          $posts = User::where('id',$user)->where('user_id',$title)->orderBy('posted_at',$sort)->paginate(10);
        }
      }
      
      
      /*
      $posts = Bbs::orderBy('id', 'desc')->simplePaginate(10);
      
      //掲載者のソート機能
      $sort = $request->sort;
      if ($sort == 'asc') {
        $posts = Bbs::orderBy('posted_at', 'asc')->simplePaginate(10);
      }elseif($sort == 'desc') {
        $posts = Bbs::orderBy('posted_at', 'desc')->simplePaginate(10);
      }
      */
      
      /*タイトル検索
      if($sort == 'asc' && $cond_title != '') {
        $posts = Bbs::where('title', $cond_title)
        ->orderBy('posted_at', 'asc')
        ->simplePaginate(10);
      }elseif($sort == 'desc' && $cond_title != '') {
        $posts = Bbs::where('title', $cond_title)
        ->orderBy('posted_at', 'desc')
        ->simplePaginate(10);
      }
      */
      
      
      
      
      /*名前の検索とソート
      if($sort == 'asc' && $cond_name != '') {
        $user = User::where('name', $cond_name)->first();
        $posts = $user->bbs()
        ->orderBy('posted_at', 'asc')
        ->simplePaginate(10);
        
      }elseif($sort == 'desc' && $cond_name != '') {
        $user = User::where('name', $cond_name)->first();
        $posts = $user->bbs()
        ->orderBy('posted_at', 'desc')
        ->simplePaginate(10);
        
      }
      */
      
      $selected1 = '';
      $selected2 = '';
      
      if($sort == 'asc') {
        $selected1 = 'selected';
      } else {
        $selected2 = 'selected';
      }
      
      var_dump($posts);
      
      return view('users.bbs.index', ['posts' => $posts, 'cond_title' => $cond_title, 'cond_name' => $cond_name, 'selected1' => $selected1, 'selected2' => $selected2 ]);
      
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
    
 }
