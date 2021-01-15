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
  public function formcreate() {
    
    return view('users.bbs.create');
  }
  
  public function create(Request $request) {
   
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
    $sort_order = $request->sort_order;
    $cond_title = $request->cond_title;
    $cond_name = $request->cond_name;
    $cond_body = $request->cond_body;
    $listing_date = $request->listing_date;
    
    $index = Bbs::orderBy('posted_at', 'desc');
    
    if($sort_order == 'user_id'){
      $index = Bbs::select('bbs.*')
      ->join('users', 'bbs.user_id', '=', 'users.id')
      ->orderBy('users.name', $sort);
    }
    
    if($listing_date != '') {
      $index->where('posted_at','like','%'.$listing_date.'%');
    }
    
    if($cond_body != '') {
      $index->where('body','like','%'.$cond_body.'%');
    }
    
    if($cond_title != '') {
      $index->where('title','like','%'.$cond_title.'%');
    }
    
    if($cond_name != '') {
      //USERクラスの名前取得
      $users = User::where('name','like','%'.$cond_name.'%')->get();
      //対象のプロパティだけのid抽出してるところ
      $ids = $users->pluck('id');
      
      $index->whereIn('user_id', $ids);
    }
    
    
    $posts = $index->Paginate(10);
    
    $selected = array(
      'posted_at' => $sort_order == 'posted_at',
      'user_name' => $sort_order == 'user_id',
    );
    
    $sort1 = array(
      'asc' => $sort == 'asc',
      'desc' => $sort == 'desc'
    );
    
    return view('users.bbs.index', ['posts' => $posts, 'cond_title' => $cond_title, 'cond_name' => $cond_name, 'cond_body' => $cond_body, 'listing_date' => $listing_date, 'sort_order' => $sort_order, 'selected' => $selected, 'sort1' => $sort1 ]);
    
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
