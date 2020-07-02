<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bbs;
use App\BbsUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BbsController extends Controller
{
    
    
    public function add()
    {
      
      return view('users.bbs.bbs_create');
      
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
      
      
      return redirect('users/bbs/bbs_list');
      
    }
    
    public function index(Request $request) {
      
      $cond_title = $request->cond_title;
      if ($cond_title != '') {

          $posts = Bbs::where('title', $cond_title)->get();
      } else {
          
          $posts = Bbs::all();
      }
      
      

      
      return view('users.bbs.bbs_list', ['posts' => $posts, 'cond_title' => $cond_title]);
      
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
      
      
      
      return redirect('users/bbs/bbs_list');
    }
    
    public function delete(Request $request)
    {
      
      $bbs = Bbs::find($request->id);

      $bbs->delete();
      return redirect('users/bbs/bbs_list');
    }
    
    
    
    
    public function front(Request $request) {
      
      $bbs = Bbs::find($request->id);
      
      
      
      return view('users/bbs/bbs_front', ['bbs' => $bbs]);
    }
    
    
 }
