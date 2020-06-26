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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'users'], function() {
    
    Route::get('mypege','Users\UserController@add');
    
    Route::get('bbs/bbs_front', 'Users\BbsController@front');
    
    Route::get('bbs/bbs_list', 'Users\BbsController@index');
    
    Route::get('bbs/bbs_create', 'Users\BbsController@add');
    Route::post('bbs/bbs_create', 'Users\BbsController@create');
    
    Route::get('bbs/edit', 'Users\BbsController@edit');
    Route::post('bbs/edit', 'Users\BbsController@update');

    
    Route::get('bbs/delete', 'Users\BbsController@delete');
    
    
    Route::get('work_schedule/my_workShedule','Users\WorkScheduleController@add');
    
    Route::get('work_schedule/whole_workShedule','Users\WorkScheduleController@whole');
    
    Route::get('work_schedule/date_workShedule','Users\WorkScheduleController@date');
    
    Route::get('work_schedule/leave_application','Users\WorkScheduleController@leave');
});

