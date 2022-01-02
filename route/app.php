<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::pattern(['openid'=>'[\w\.\-]+']);
Route::miss('err');

Route::get('login/:code','Login/getOpenId');
Route::get('user/:openid','User/getRegStatus');
Route::get('userInfo/:openid','User/getUserInfo');

Route::post('upload','Upload/upload');
Route::delete('upload/del','Upload/del');

Route::get('reg/status/:openid','Reg/getRegStatus');
Route::post('reg','Reg/save');

Route::post('tasks','Tasks/save');
Route::delete('tasks','Tasks/deleteTask');

Route::get('tasksList/:openid','User/getTasksList');
Route::get('tasksInfo/:openid/:taskId','User/getTasksInfo');

Route::post("login",'AdminLogin/login');
Route::group('admin', function () {
    Route::get('menus','Admin/getMenus');
    Route::get('users','Admin/getUsersList');
    Route::delete('users/:id','Admin/deleteUser');
    Route::get('userInfo','Admin/getUserInfo');
    Route::put('userInfo','Admin/updateUserInfo');
    Route::put('userStatus/:id','Admin/updateIsOk');
    /////////////////////////////////////////////////
    Route::get('tasks','Admin/getTasksList');
    Route::delete('tasks/:id','Admin/deleteTask');
    Route::get('taskInfo','Admin/getTaskInfo');
    Route::put('taskInfo','Admin/updateTaskInfo');
})->middleware('check');
