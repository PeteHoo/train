<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ChooseQuestionBatch;
use App\Admin\Repositories\Exam;
use App\Models\Industry;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Models\TestQuestion;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ExamController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Exam(), function (Grid $grid) {
            if (Admin::user()->isRole('mechanism')) {
                $grid->model()->where('mechanism_id', Admin::user()->id);
            }
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('mechanism_id')->display(function ($mechanism_id){
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('industry_id')->display(function ($industry_id){
                return Industry::getIndustryDataDetail($industry_id);
            });
            $grid->column('occupation_id')->display(function ($occupation_id){
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $grid->column('score');
            $grid->column('question_count');
            $grid->column('status')->switch();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->actions(function (Grid\Displayers\Actions $actions){
                $actions->append('<a href="exam-detail?exam_id='.$actions->row->id.'"><i class="fa fa-eye">题目详情</i></a>');
            });
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
        return Show::make($id, new Exam(), function (Show $show) {
            $show->disableEditButton();
            $show->row(function (Show\Row $show) {
                $show->width(12)->field('name');
            });
            $show->row(function (Show\Row $show) {
                $show->width(4)->field('mechanism_id')->as(function ($mechanism_id){
                    return Mechanism::getMechanismDataDetail($mechanism_id);
                });
                $show->width(4)->field('industry_id')->as(function ($industry_id){
                    return Industry::getIndustryDataDetail($industry_id);
                });
                $show->width(4)->field('occupation_id')->as(function ($occupation_id){
                    return Occupation::getOccupationDataDetail($occupation_id);
                });
            });
            $show->row(function (Show\Row $show) {
                $show->width(4)->field('score');
                $show->width(4)->field('question_count');
                $show->width(4)->field('status')->as(function ($status){
                    return Constants::getStatusType($status);
                });
            });
            $show->judgment(function ($model)use($show) {
                $grid = new Grid(new TestQuestion());
                if (Admin::user()->isRole('administrator')) {
                    $grid->model()->where('type',Constants::JUDGMENT);
                } elseif (Admin::user()->isRole('mechanism')) {
                    $grid->model()->where('mechanism_id', $model->mechanism_id)->where('type',Constants::JUDGMENT);
                }
                $grid->setResource('test-question');
                $grid->column('type')->display(function ($type){
                    return Constants::getQuestionType($type);
                });
                $grid->column('attributes')->display(function ($attributes){
                    return Constants::getQuestionAttributeType($attributes);
                });
                $grid->column('description');
                $grid->column('description_image')->image();
                $grid->column('选项')->display(function (){
                    if($this->type==Constants::SINGLE_CHOICE){
                        return u2c($this->answer_single_option);
                    }else{
                        return u2c($this->answer_judgment_option);
                    }
                });
                $grid->column('答案')->display(function (){
                    if($this->type==Constants::SINGLE_CHOICE){
                        return u2c($this->true_single_answer);
                    }else{
                        return u2c($this->true_judgment_answer);
                    }
                });

                $grid->column('mechanism_id')->display(function ($mechanism_id){
                    return Mechanism::getMechanismDataDetail($mechanism_id);
                });
                $grid->column('created_at');
                $grid->column('updated_at')->sortable();

                $grid->filter(function (Grid\Filter $filter) {
                    $filter->like('description');
                    $filter->equal('attributes')->select(Constants::getQuestionAttributeItems());
                });
                $grid->disableDeleteButton();
                $grid->batchActions(function(Grid\Tools\BatchActions $actions)use($show){
                    $actions->add(new ChooseQuestionBatch($show->model()->id,Constants::JUDGMENT));
                });
                return $grid;
            });
            $show->single(function ($model)use($show) {
                $grid = new Grid(new TestQuestion());
                if (Admin::user()->isRole('administrator')) {
                    $grid->model()->where('type',Constants::SINGLE_CHOICE);
                } elseif (Admin::user()->isRole('mechanism')) {
                    $grid->model()->where('mechanism_id', $model->mechanism_id)->where('type',Constants::SINGLE_CHOICE);
                }

                $grid->setResource('test-question');
                $grid->column('type')->display(function ($type){
                    return Constants::getQuestionType($type);
                });
                $grid->column('attributes')->display(function ($attributes){
                    return Constants::getQuestionAttributeType($attributes);
                });
                $grid->column('description');
                $grid->column('description_image')->image();
                $grid->column('选项')->display(function (){
                    if($this->type==Constants::SINGLE_CHOICE){
                        return u2c($this->answer_single_option);
                    }else{
                        return u2c($this->answer_judgment_option);
                    }
                });
                $grid->column('答案')->display(function (){
                    if($this->type==Constants::SINGLE_CHOICE){
                        return u2c($this->true_single_answer);
                    }else{
                        return u2c($this->true_judgment_answer);
                    }
                });

                $grid->column('mechanism_id')->display(function ($mechanism_id){
                    return Mechanism::getMechanismDataDetail($mechanism_id);
                });
                $grid->column('created_at');
                $grid->column('updated_at')->sortable();
                $grid->filter(function (Grid\Filter $filter) {
                    $filter->like('description');
                    $filter->equal('attributes')->select(Constants::getQuestionAttributeItems());
                });
                $grid->disableDeleteButton();
                $grid->batchActions(function(Grid\Tools\BatchActions $actions)use($show){
                    $actions->add(new ChooseQuestionBatch($show->model()->id,Constants::SINGLE_CHOICE));
                });
                return $grid;
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Exam(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            if (Admin::user()->isRole('administrator')) {
                $form->select('mechanism_id')->options(Mechanism::getMechanismData());
            } elseif (Admin::user()->isRole('mechanism')) {
                $form->hidden('mechanism_id')->default(Admin::user()->id);
            }
            $form->select('industry_id')->options(Industry::getIndustryData())->load('occupation_id', 'api-occupation');
            $form->select('occupation_id');
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');
            $form->hidden('score');
            $form->hidden('question_count');
            $form->saving(function (Form $form) {
                $occupation = Occupation::find($form->occupation_id);
                if ($occupation) {
                    $form->score = $occupation->choice_question_num * $occupation->choice_question_score + $occupation->judgment_question_num * $occupation->judgment_question_score;
                    $form->question_count = $occupation->choice_question_num + $occupation->judgment_question_num;
                } else {
                    $form->score = 0;
                    $form->question_count = 0;
                }

            });
        });
    }
}
