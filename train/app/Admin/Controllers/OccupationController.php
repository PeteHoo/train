<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Occupation;
use App\Models\Exam;
use App\Models\Industry;
use App\Models\LearningMaterial;
use App\Models\TestQuestion;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class OccupationController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Occupation(), function (Grid $grid) {
            $grid->model()->orderBy('id','DESC');
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('industry_id')->display(function ($industry_id){
                return Industry::getIndustryDataDetail($industry_id);
            });
            $grid->column('choice_question_num');
            $grid->column('choice_question_score');
            $grid->column('judgment_question_num');
            $grid->column('judgment_question_score');
            $grid->column('exam_time');
            $grid->column('passing_grade');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            if(config('app.name')=='食安员培训'){
                $grid->disableDeleteButton();
                $grid->disableCreateButton();
                $grid->disableBatchDelete();
            }
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Occupation(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('industry_id')->as(function ($industry_id){
                return Industry::getIndustryDataDetail($industry_id);
            });
            $show->field('choice_question_num');
            $show->field('choice_question_score');
            $show->field('judgment_question_num');
            $show->field('judgment_question_score');
            $show->field('exam_time');
            $show->field('passing_grade');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Occupation(), function (Form $form) {
            $form->display('id');
            if(config('app.name')=='共乐学堂'){
                $form->text('name')->maxLength(6);
                $form->select('industry_id')->options(Industry::getIndustryData())->required();
            }
            $form->number('choice_question_num');
            $form->number('choice_question_score');
            $form->number('judgment_question_num');
            $form->number('judgment_question_score');
            $form->number('exam_time');
            $form->number('passing_grade');

            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function (Form $form) {
                if($form->isCreating()){
                    $occupation = \App\Models\Occupation::where('name',$form->name)->first();
                    if ($occupation) {
                        return $form->response()
                            ->error('该职业名已存在');
                    }
                }
            });
            $form->deleting(function (Form $form) {
                // 获取待删除行数据，这里获取的是一个二维数组
                $data = $form->model()->toArray();
                foreach ($data as $k=>$v){
                    if(LearningMaterial::where('occupation_id',$v['id'])->count()){
                        return $form->response()
                            ->error($v['name'].'下还有课程不能删除');
                    }
                    if(TestQuestion::where('occupation_id',$v['id'])->count()){
                        return $form->response()
                            ->error($v['name'].'下还有试题不能删除');
                    }
                    if(Exam::where('occupation_id',$v['id'])->count()){
                        return $form->response()
                            ->error($v['name'].'下还有试卷不能删除');
                    }
                }
            });
        });
    }
}
