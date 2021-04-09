<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();
Route::get('/admin/auth/register','App\Admin\Controllers\RegisterController@register');
Route::post('/admin/auth/send-code','App\Admin\Controllers\RegisterController@sendCode');
Route::post('/admin/auth/verify-code','App\Admin\Controllers\RegisterController@verifyCode');
Route::get('/admin/auth/base-info','App\Admin\Controllers\RegisterController@baseInfo');
Route::resource('/admin/register','App\Admin\Controllers\RegisterController');

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('version', 'VersionController');
    $router->resource('exhibition', 'ExhibitionController');
    $router->resource('industry', 'IndustryController');
    $router->resource('occupation', 'OccupationController');
    $router->resource('update-plan', 'UpdatePlanController');
    $router->resource('feedback', 'FeedbackController');
    $router->resource('agreement', 'AgreementController');
    $router->resource('mechanism', 'MechanismController');
    $router->resource('learning-material', 'LearningMaterialController');


    $router->get('api-version','ApiController@version');
    $router->get('api-occupation','ApiController@occupation');

});

