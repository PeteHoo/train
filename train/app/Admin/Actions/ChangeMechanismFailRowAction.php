<?php


namespace App\Admin\Actions;


use App\Models\AppUser;
use App\Utils\Constants;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class ChangeMechanismFailRowAction extends RowAction
{

    protected $title='回退机构';
    public function confirm()
    {
        return '您确定要回退该账号的修改机构吗？';
    }

    public function handle(Request $request)
    {
        // 获取主键
        $key = $this->getKey();
        $appUser=AppUser::find($key);
        $appUser->temp_mechanism_id=0;
        $appUser->status=Constants::VERIFIED;
        $appUser->save();
        return $this->response()
            ->success('回退成功')->refresh();
    }



    // 设置请求参数
    public function parameters()
    {
        return [];
    }
}

{

}
