<?php


namespace App\Admin\Controllers;


use App\Models\Exam;
use App\Models\ExamDetail;
use App\Models\TestQuestion;
use App\Utils\Constants;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class ExamDetailController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new ExamDetail(), function (Grid $grid) {
            $grid->model()->where('exam_id',request()->get('exam_id'))->orderBy('sort','DESC');
            $grid->column('id')->sortable();
            $grid->column('question_id')->display(function ($question_id){
                $testQuestion=TestQuestion::find($question_id);
                if(!$testQuestion){
                    return '';
                }
                if($testQuestion->attributes==Constants::TEXT){
                    return $testQuestion->description;
                }else{
                    return '<img src="'.config('app.url').'/'.$testQuestion->description_image.'">';
                }
            });
            $grid->column('type')->display(function ($type){
                return Constants::getQuestionType($type);
            });
            $grid->column('created_at');
            $grid->column('updated_at');
            $grid->column('sort')->editable();
            $grid->disableEditButton();
            $grid->disableCreateButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    protected function detail($id)
    {
        return Show::make($id, new ExamDetail(), function (Show $show) {
            $show->field('id');
            $show->field('exam_id')->as(function ($exam_id){
                return Exam::find($exam_id)->name??'';
            });
            $show->field('question_id')->as(function ($exam_id){
                $testQuestion=TestQuestion::find($exam_id);
                if($testQuestion->attributes??0==Constants::TEXT){
                    return $testQuestion->description;
                }elseif($testQuestion->attributes??0==Constants::IMAGE){
                    return '<img src="'.config('app.url').'/'.$testQuestion->description_image.'">';
                }else{
                    return '';
                }
            });
            $show->field('type')->as(function ($type){
                return Constants::getQuestionType($type);
            });
            $show->field('sort');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new ExamDetail(), function (Form $form) {
            $form->display('id');
            $form->number('sort')->default(0);
            $form->display('created_at');
            $form->display('updated_at');

            $form->deleted(function (Form $form, $result) {
                // 获取待删除行数据，这里获取的是一个二维数组
                $dataArray = $form->model()->toArray();

                // 通过 $result 可以判断数据是否删除成功
                if (! $result) {
                    return $form->response()->error('数据删除失败');
                }
               foreach ($dataArray as $k=>$data){

               }
                $exam=Exam::where('id',$data['exam_id'])->first();
                if($data['type']==Constants::SINGLE_CHOICE){
                    $single_item_array=json_decode($exam->single_item);
                    $single_item_result=array_diff($single_item_array,(array)($data['question_id']));
                    $single_item_result=array_values($single_item_result);
                    $exam->single_item=json_encode($single_item_result);
                    $exam->save();
                }elseif($data['type']==Constants::JUDGMENT){
                    $judgment_item_array=json_decode($exam->judgment_item);
                    $judgment_item_result=array_diff($judgment_item_array,(array)$data['question_id']);
                    $judgment_item_result=array_values($judgment_item_result);
                    $exam->judgment_item=json_encode($judgment_item_result);
                    $exam->save();
                }
                // 返回删除成功提醒，此处跳转参数无效
                return $form->response()->success('删除成功');
            });

        });
    }

}
