<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ChooseQuestionBatch;
use App\Admin\Repositories\TestQuestion;
use App\Models\Mechanism;
use App\Models\Occupation;
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
            $grid->setResource('test-question');
            if (Admin::user()->isRole('mechanism')) {
                $grid->model()->where('mechanism_id', Admin::user()->id);
            }
            $grid->column('id')->sortable();
            $grid->column('type')->display(function ($type) {
                return Constants::getQuestionType($type);
            });
            $grid->column('description');
//            $grid->column('description_image')->display(function ($description_image){
//                return json_decode($description_image,true);
//            })->image(config('app.file_url'), 50, 50);
            $grid->column('选项')->display(function () {
                if($this->type==Constants::JUDGMENT){
                    return '';
                }
                $answer_single_option=json_decode($this->answer_single_option);
                $result=array();
                if($answer_single_option){
                    foreach ($answer_single_option as $k=>$v){
                        $result[]=$v->选项.':'.$v->答案;
                    }
                }
                return json_encode($result);
            });
            $grid->column('答案')->display(function () {
                if ($this->type == Constants::SINGLE_CHOICE) {
                    return $this->true_single_answer;
                } else {
                    return $this->true_judgment_answer;
                }
            });
            $grid->column('mechanism_id')->display(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('occupation_id')->display(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('type')->select(Constants::getQuestionTypeItems());
                $filter->equal('mechanism_id')->select(Mechanism::getMechanismData());
                $filter->equal('occupation_id')->select(Occupation::getOccupationData());

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
            $show->field('type')->as(function ($type) {
                return Constants::getQuestionType($type);
            });
            $show->field('description');

            $show->field('description');

            $show->field('description_image')->image();

            $show->field('选项')->as(function () use ($show) {
                if ($show->model()->type == Constants::SINGLE_CHOICE) {
                    return u2c($show->model()->answer_single_option);
                } else {
                    return '';
                }
            });
            $show->field('答案')->as(function () use ($show) {
                if ($this->type == Constants::SINGLE_CHOICE) {
                    return u2c($show->model()->true_single_answer);
                } else {
                    return u2c($show->model()->true_judgment_answer);
                }
            });
            $show->field('mechanism_id')->as(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $show->field('occupation_id')->as(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
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
            $form->textarea('description');
            $form->multipleImage('description_image')->savingArray();
            $form->hidden('answer_single_option');

            $form->select('type')->required()->options(Constants::getQuestionTypeItems())
                ->when(Constants::SINGLE_CHOICE, function ($form) {
//                    $form->table('answer_single_option', function (NestedForm $table) {
//                        //$table->select('选项')->options(Constants::getSingleChoiceOptionItems());
//                        $table->text('option');
//                    })->savingArray();
                    //dd($form->answer_single_option);
                    $answer_single_option=json_decode($form->model()->answer_single_option);
                    $a=$answer_single_option[0]??'';
                    $b=$answer_single_option[1]??'';
                    $c=$answer_single_option[2]??'';
                    $d=$answer_single_option[3]??'';

                    $form->text('A')->placeholder('请输入答案')->value($a->答案??'');
                    $form->text('B')->placeholder('请输入答案')->value($b->答案??'');
                    $form->text('C')->placeholder('请输入答案')->value($c->答案??'');
                    $form->text('D')->placeholder('请输入答案')->value($d->答案??'');
                    $form->select('true_single_answer')->options(Constants::getSingleChoiceOptionItems());
                })
                ->when(Constants::JUDGMENT, function ($form) {
                    $form->select('true_judgment_answer')->options(Constants::getJudgmentOptionItems());
                });
            $form->hidden('mechanism_id')->default(Admin::user()->id);
            $form->select('occupation_id')->required()->options(Occupation::getOccupationData());
            $form->display('created_at');
            $form->display('updated_at');
            $form->saving(function ($form){
                $data[0]['选项']='A';
                $data[0]['答案']=$form->input('A');
                $data[1]['选项']='B';
                $data[1]['答案']=$form->input('B');
                $data[2]['选项']='C';
                $data[2]['答案']=$form->input('C');
                $data[3]['选项']='D';
                $data[3]['答案']=$form->input('D');

                $form->answer_single_option=json_encode($data);
                $form->deleteInput('A');
                $form->deleteInput('B');
                $form->deleteInput('C');
                $form->deleteInput('D');
            });
        });
    }
}
