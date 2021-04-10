<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/10
 * Time: 12:02
 */

namespace App\Admin\Controllers;


use Dcat\Admin\Http\Controllers\AdminController;

class StepController extends AdminController
{
    public function register()
    {
    return admin_success('成功','成功');
    }
}