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
      
      
      $bbs->posted_at = Carbon::now();
      
      $bbs->user_id = Auth::id();
      
      $bbs->fill($form);
      
      $bbs->save();
      
      
      return redirect('users/bbs/index');
      
    }
    
    
    
    public function index(Request $request) {
      
      $sort = $request->sort;
      $cond_title = $request->cond_title;
      $cond_name = $request->cond_name;
      
      if($cond_title == '' && $cond_name == '') {
        $posts = Bbs::orderBy('posted_at', $sort)->simplePaginate(10);
      }
      
      if($cond_title != '') {
        $posts = Bbs::where('title','like','%'.$cond_title.'%')
        ->orderBy('posted_at', $sort)
        ->simplePaginate(10);
      }
      
      $user = User::where('name','like','%'.$cond_name.'%')->first();
      
      if($cond_name != '') {
        if (is_null($user)){
          $posts = Bbs::where('id', null)->simplePaginate(10);
        } else {
          $posts = $user->bbs()
          ->orderBy('posted_at', $sort)
          ->simplePaginate(10);
        }
      }
      
      if($cond_title != '' && $cond_name != '') {
        if(is_null($user)) {
          $posts = Bbs::where('id', null)->simplePaginate(10);
        } else {
          $posts = Bbs::where('user_id', $user->id)
          ->where('title','like','%'.$cond_title.'%')
          ->orderBy('posted_at', $sort)
          ->simplePaginate(10);
        }
      }
      
      $selected1 = '';
      $selected2 = '';
      
      if($sort == 'asc') {
        $selected1 = 'selected';
      } else {
        $selected2 = 'selected';
      }
      
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
