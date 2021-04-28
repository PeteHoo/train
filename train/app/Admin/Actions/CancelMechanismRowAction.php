<?php


namespace App\Admin\Actions;


use App\Models\AppUser;
use App\Utils\Constants;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class CancelMechanismRowAction extends RowAction
{
    protected $title='剔除机构';
    public function confirm()
    {
        return '您确定要剔除该账号吗？';
    }

    public function handle(Request $request)
    {
        // 获取主键
        $key = $this->getKey();
        $appUser=AppUser::find($key);
        //恢复成平台用户
        $appUser->mechanism_id=1;
        $appUser->temp_mechanism_id=1;
        $appUser->status=Constants::OPEN;
        $appUser->save();
        return $this->response()
            ->success('剔除成功')->refresh();
    }



    // 设置请求参数
    public function parameters()
    {
        return [];
    }
}
