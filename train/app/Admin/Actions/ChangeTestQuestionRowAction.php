<?php


namespace App\Admin\Actions;


use App\Models\AppUser;
use App\Models\TestQuestion;
use App\Utils\Constants;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class ChangeTestQuestionRowAction extends RowAction
{

    protected $title='[修改试题]';
    public function confirm()
    {
        return '您确定要修改试题吗？';
    }

    public function handle(Request $request)
    {
        // 获取主键
        $key = $this->getKey();
        $testQuestion=TestQuestion::find($key);
        $testQuestion->description=$testQuestion->temp_description;
        $testQuestion->description_image=$testQuestion->temp_description_image;
        $testQuestion->answer_single_option=$testQuestion->temp_answer_single_option;
        $testQuestion->true_single_answer=$testQuestion->temp_true_single_answer;
        $testQuestion->true_judgment_answer=$testQuestion->temp_true_judgment_answer;
        $testQuestion->is_open=$testQuestion->temp_is_open;
        $testQuestion->temp_description='';
        $testQuestion->temp_description_image='';
        $testQuestion->temp_answer_single_option='';
        $testQuestion->temp_true_single_answer='';
        $testQuestion->temp_true_judgment_answer='';
        $testQuestion->status=Constants::VERIFIED;
        $testQuestion->save();
        return $this->response()
            ->success('修改成功')->refresh();
    }

    // 设置请求参数
    public function parameters()
    {
        return [];
    }
}
