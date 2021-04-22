<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([],function ($route){
    //登录相关接口
    $route->post('user/send-code','Api\UserController@sendCode');//发送短信
    $route->post('user/code-login','Api\UserController@codeLogin');//短信登录
    $route->post('user/code-change-password','Api\UserController@codeChangePassword');//短信修改密码
    $route->post('user/password-login','Api\UserController@passwordLogin');//密码登录


});

Route::group(['middleware' => ['auth.api']], function ($route) {
    //考试相关接口
    $route->post('exam/add-record','Api\ExamController@addRecord');//上传考试记录
    $route->get('exam/records','Api\ExamController@records');//考试概况

    //更新个人信息
    $route->post('user/update-info','Api\UserController@updateInfo');//考试概况
    $route->get('user/info','Api\UserController@info');//考试概况
    $route->post('user/change-password','Api\UserController@changePassword');//考试概况

    $route->get('learning-material/list','Api\LearningMaterialController@materialList');//资料列表
    $route->get('learning-material/detail','Api\LearningMaterialController@materialDetail');//资料详情
    $route->get('learning-material/search','Api\LearningMaterialController@searchMaterial');//资料搜素

    $route->get('exam/list','Api\ExamController@examList');//考试列表

    $route->get('base-data/industry','Api\BaseDataController@industry');//行业数据
    $route->get('base-data/occupation','Api\BaseDataController@occupation');//职业数据


});

