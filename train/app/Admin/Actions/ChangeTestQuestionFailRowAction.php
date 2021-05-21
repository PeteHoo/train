<?php


namespace App\Admin\Actions;


use App\Models\AppUser;
use App\Models\TestQuestion;
use App\Utils\Constants;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class ChangeTestQuestionFailRowAction extends RowAction
{

    protected $title='[回退试题]';
    public function confirm()
    {
        return '您确定要回退试题吗？';
    }

    public function handle(Request $request)
    {
        // 获取主键
        $key = $this->getKey();
        $testQuestion=TestQuestion::find($key);
        $testQuestion->temp_description='';
        $testQuestion->temp_description_image='';
        $testQuestion->temp_answer_single_option='';
        $testQuestion->temp_true_single_answer='';
        $testQuestion->temp_true_judgment_answer='';
        $testQuestion->status=Constants::VERIFIED;
        $testQuestion->save();
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
