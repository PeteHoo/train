<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TestQuestion;
use App\Models\Mechanism;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TestQuestionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TestQuestion(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('type')->display(function ($type){
                return Constants::getQuestionType($type);
            });
            $grid->column('attributes')->display(function ($attributes){
                return Constants::getQuestionAttributeType($attributes);
            });
            $grid->column('description');
            $grid->column('description_image');
            $grid->column('选项')->display(function (){
                if($this->type==Constants::SINGLE_CHOICE){
                    return u2c($this->answer_single_option);
                }else{
                    return $this->answer_judgment_option;
                }
            });
            $grid->column('答案')->display(function (){
                if($this->type==Constants::SINGLE_CHOICE){
                    return u2c($this->true_single_answer);
                }else{
                    return $this->true_judgment_answer;
                }
            });

            $grid->column('mechanism_id')->display(function ($mechanism_id){
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

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
        return Show::make($id, new TestQuestion(), function (Show $show) {
            $show->field('id');
            $show->field('type')->as(function ($type){
                return Constants::getQuestionType($type);
            });;
            $show->field('attributes')->as(function ($attributes){
                return Constants::getQuestionAttributeType($attributes);
            });;
            $show->field('description');
            $show->field('description_image');
            $show->field('answer_single_option');
            $show->field('true_single_answer');
            $show->field('answer_judgment_option');
            $show->field('true_judgment_answer');
            $show->field('mechanism_id')->as(function ($mechanism_id){
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });;
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
        return Form::make(new TestQuestion(), function (Form $form) {
            $form->display('id');
            $form->select('attributes')->options(Constants::getQuestionAttributeItems())->when(Constants::TEXT,function ($form){
                $form->textarea('description');
            })->when(Constants::IMAGE,function ($form){
                $form->image('description_image');
            });
            $form->select('type')->options(Constants::getQuestionTypeItems())
                ->when(Constants::SINGLE_CHOICE,function ($form){
                $form->table('answer_single_option',function (NestedForm $table){
                    $table->select('选项')->options(Constants::getSingleChoiceOptionItems());
                    $table->text('答案');
                })->savingArray();
                $form->select('true_single_answer')->options(Constants::getSingleChoiceOptionItems());
            })
                ->when(Constants::JUDGMENT,function ($form){
                $form->table('answer_judgment_option',function (NestedForm $table1){
                    $table1->select('选项')->options(Constants::getJudgmentOptionItems());
                    $table1->text('答案');
                })->savingArray();
                $form->select('true_judgment_answer')->options(Constants::getJudgmentOptionItems());
            });

            if(Admin::user()->isRole('administrator')){
                $form->select('mechanism_id')->options([0=>'平台']+Mechanism::getMechanismData());
            }elseif(Admin::user()->isRole('mechanism')){
                $form->hidden('mechanism_id')->default(Admin::user()->id);
            }
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
