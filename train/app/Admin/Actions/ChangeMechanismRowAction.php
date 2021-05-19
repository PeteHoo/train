<?php


namespace App\Admin\Actions;


use App\Models\AppUser;
use App\Utils\Constants;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class ChangeMechanismRowAction extends RowAction
{

    protected $title='[修改机构]';
    public function confirm()
    {
        return '您确定要修改该账号的机构吗？';
    }

    public function handle(Request $request)
    {
        // 获取主键
        $key = $this->getKey();
        $appUser=AppUser::find($key);
        $appUser->mechanism_id=$appUser->temp_mechanism_id;
        $appUser->temp_mechanism_id=0;
        $appUser->status=Constants::VERIFIED;
        $appUser->save();
        return $this->response()
            ->success('修改成功')->refresh();
    }

    // 设置请求参数
    public function parameters()
    {
        return [];
    }
}
