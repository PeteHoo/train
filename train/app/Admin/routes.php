<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();


Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    $router->group([ 'middleware' => config('admin.route.middleware')],function (Router $router){
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

    $router->get('auth/register','RegisterController@register');
    $router->post('auth/send-code','RegisterController@sendCode');
    $router->post('auth/verify-code','RegisterController@verifyCode');
    $router->post('step','StepController@register');
    $router->resource('register','RegisterController');
    $router->any('file-register','FileController@registerFiles');
    $router->get('api-region','RegionController@backend');
});

