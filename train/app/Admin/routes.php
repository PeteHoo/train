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
        $router->get('/', 'TestQuestionController@index');
        $router->resource('app-name', 'AppNameController');
        $router->resource('version', 'VersionController');
        $router->resource('exhibition', 'ExhibitionController');
        $router->resource('industry', 'IndustryController');
        $router->resource('occupation', 'OccupationController');
        $router->resource('update-plan', 'UpdatePlanController');
        $router->resource('feedback', 'FeedbackController');
        $router->resource('agreement', 'AgreementController');
        $router->resource('mechanism', 'MechanismController');
        $router->resource('learning-material', 'LearningMaterialController');
        $router->resource('learning-material-chapter', 'LearningMaterialChapterController');
        $router->resource('learning-material-detail', 'LearningMaterialDetailController');
        $router->resource('test-question', 'TestQuestionController');
        $router->get('test-question-excel/import', 'TestQuestionExcelController@importExcel');
        $router->resource('exam', 'ExamController');
        $router->resource('exam-detail', 'ExamDetailController');
        $router->resource('app-user', 'AppUserController');
        $router->resource('special', 'SpecialController');
        $router->resource('hot-search', 'HotSearchController');

        $router->resource('auth/users', 'UserController');


        $router->get('api-version','ApiController@version');
        $router->get('api-occupation','ApiController@occupation');
        $router->get('api-industry','ApiController@industry');
        $router->get('api-chapter','ApiController@chapter');


    });
    $router->get('home','RegisterController@home');//新版首页
    $router->get('forgot-password','RegisterController@forgotPassword');//找回密码
    $router->post('send-forgot-password-code','RegisterController@sendFindPasswordCode');//找回密码
    $router->post('verify-forgot-password-code','RegisterController@verifyForgotPasswordCode');//找回密码
    $router->get('change-password-page','RegisterController@changePasswordPage');//找回密码
    $router->post('change-password','RegisterController@changePassword');//找回密码
    $router->get('phone-register','RegisterController@register');
    $router->post('send-code','RegisterController@sendCode');
    $router->post('verify-code','RegisterController@verifyCode');
    $router->post('step','StepController@register');
    $router->resource('register','RegisterController');
    $router->get('register/{phone}/{code}','RegisterController@create');
    $router->any('file-register','FileController@registerFiles');
    $router->any('file-material','FileController@materialFiles');
    $router->get('api-region','RegionController@backend');
});

