<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Dcat\Admin\Layout\Content;


class AuthController extends BaseAuthController
{
    public function register(Content $content){
        return $content
            ->header('注册')
            ->full()
            ->body(view('register'));
    }

    public function sendCode(){

    }

}
