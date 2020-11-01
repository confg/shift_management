<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');


Route::get('/home', 'HomeController@home')->name('home');


//ゲート機能で管理者のみアクセス可
Route::group(['prefix' => 'users', 'middleware' => ['auth', 'can:admin']], function () {
    
	Route::get('leave/management','Users\LeaveController@management');
	Route::get('leave/front','Users\LeaveController@front');
	
	Route::get('work_schedule/whole','Users\WorkScheduleController@whole');
	
	
});





Route::group(['prefix' => 'users', 'middleware' => 'auth'], function() {
    
    
    Route::get('mypege','Users\UserController@add');
    
    
    
    Route::get('bbs/front', 'Users\BbsController@front');
    
    Route::get('bbs/index', 'Users\BbsController@index');
    
    Route::get('bbs/create', 'Users\BbsController@add');
    Route::post('bbs/create', 'Users\BbsController@create');
    
    Route::get('bbs/edit', 'Users\BbsController@edit');
    Route::post('bbs/edit', 'Users\BbsController@update');

    Route::get('bbs/delete', 'Users\BbsController@delete');
    
    
    
    Route::get('work_schedule/my','Users\WorkScheduleController@add');
    Route::post('work_schedule/my','Users\WorkScheduleController@attendance');
    
    Route::get('work_schedule/next','Users\WorkScheduleController@monthmove');
   
    
    
    
    Route::get('work_schedule/date','Users\WorkScheduleController@date');
    
    Route::post('work_schedule/date','Users\WorkScheduleController@update');
    
    
    
    Route::get('leave/application','Users\LeaveController@leave');
    Route::post('leave/application','Users\LeaveController@application');
    
    
    
    Route::get('leave/result','Users\LeaveController@result');
    
    Route::post('leave/test','Users\LeaveController@update');
    
   
    
});

