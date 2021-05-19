<?php
/**
 * Created by PhpStorm.
 * User: 35304
 * Date: 2021/5/19
 * Time: 19:55
 */

namespace App\Admin\Actions;

use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Models\Administrator;

class ResetPasswordRowAction extends RowAction
{
    protected $title = '[重置密码]';

    public function confirm()
    {
        return '您确定要重置密码吗？';
    }

    public function handle()
    {
        // 获取主键
        $key = $this->getKey();
        $administrator = Administrator::find($key);
        //重置密码
        $administrator->password = bcrypt(123456);
        $administrator->save();
        return $this->response()
            ->success('重置成功')->refresh();
    }



    // 设置请求参数
    public function parameters()
    {
        return [];
    }
}