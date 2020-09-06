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

Route::group(['prefix' => 'users', 'middleware' => 'auth'], function() {
    
    
    Route::get('mypege','Users\UserController@add');
    
    
    
    Route::get('bbs/bbs_front', 'Users\BbsController@front');
    
    Route::get('bbs/index', 'Users\BbsController@index');
    
    Route::get('bbs/create', 'Users\BbsController@add');
    Route::post('bbs/create', 'Users\BbsController@create');
    
    Route::get('bbs/edit', 'Users\BbsController@edit');
    Route::post('bbs/edit', 'Users\BbsController@update');

    Route::get('bbs/delete', 'Users\BbsController@delete');
    
    
    
    
    Route::get('work_schedule/my','Users\WorkScheduleController@add');
    
    
    
    Route::get('work_schedule/whole','Users\WorkScheduleController@whole');
    
    Route::get('work_schedule/date','Users\WorkScheduleController@date');
    
    Route::post('work_schedule/date','Users\WorkScheduleController@update');
    
    Route::get('work_schedule/leave_application','Users\WorkScheduleController@leave');
    
    Route::get('work_schedule/sample','Users\WorkScheduleController@sample');
});

