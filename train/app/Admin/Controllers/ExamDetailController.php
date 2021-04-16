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
        });
    }

}
