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

// 欢迎页面 
Route::get('/', function () {
    return view('welcome');
});

// 后台
Route::group([],function(){
	Route::get('admin/index','admin\IndexController@index');
	//用户
	Route::resource('admin/user','admin\UsersController');
});


// 前台
Route::group([],function(){

});