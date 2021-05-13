<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ChooseQuestionBatch;
use App\Admin\Forms\TestQuestionExcelForm;
use App\Admin\Repositories\TestQuestion;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Str;

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
            $grid->model()->orderBy('created_at','DESC');
            $grid->setResource('test-question');
            if (Admin::user()->isRole('mechanism')) {
                $grid->model()->where('mechanism_id', Admin::user()->id);
            }
            $grid->column('id')->sortable();
            $grid->column('type')->display(function ($type) {
                return Constants::getQuestionType($type);
            });
            $grid->column('description')->display(function ($description) {
                return mb_chunk_split($description, 15, "<br>");
            });
            $grid->column('选项')->display(function () {
                if ($this->type == Constants::JUDGMENT) {
                    return '';
                }
                return json_decode($this->answer_single_option) ?? '';
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
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('type')->select(Constants::getQuestionTypeItems());
                $filter->equal('mechanism_id')->select(Mechanism::getMechanismData());
                $filter->equal('occupation_id')->select(Occupation::getOccupationData());

            });
            $grid->tools('<a class="btn btn-primary" href="test-question-excel/import">excel试题导入</a>');
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

            $show->field('选项')->as(function () {
                if ($this->type == Constants::JUDGMENT) {
                    return '';
                }
                return $this->answer_single_option;
            });
            $show->field('答案')->as(function () {
                if ($this->type == Constants::SINGLE_CHOICE) {
                    return $this->true_single_answer;
                } else {
                    return $this->true_judgment_answer;
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
            $form->textarea('description')->attribute('maxlength', 100);
            $form->multipleImage('description_image')->savingArray();
            $form->hidden('answer_single_option');

            $form->select('type')->required()->options(Constants::getQuestionTypeItems())
                ->when(Constants::SINGLE_CHOICE, function ($form) {
                    $answer_single_option = json_decode($form->model()->answer_single_option, true);
                    if ($answer_single_option) {
                        foreach ($answer_single_option as $k => $v) {
                            if ($k == 'A') {
                                $form->text('A')->placeholder('请输入答案')->value($v ?? '');
                            }
                            if ($k == 'B') {
                                $form->text('B')->placeholder('请输入答案')->value($v ?? '');
                            }
                            if ($k == 'C') {
                                $form->text('C')->placeholder('请输入答案')->value($v ?? '');
                            }
                            if ($k == 'D') {
                                $form->text('D')->placeholder('请输入答案')->value($v ?? '');
                            }
                        }
                    }else{
                        $form->text('A')->placeholder('请输入答案');
                        $form->text('B')->placeholder('请输入答案');
                        $form->text('C')->placeholder('请输入答案');
                        $form->text('D')->placeholder('请输入答案');
                    }
                    $form->select('true_single_answer')->options(Constants::getSingleChoiceOptionItems());
                })
                ->when(Constants::JUDGMENT, function ($form) {
                    $form->select('true_judgment_answer')->options(Constants::getJudgmentOptionItems());
                });
            $form->hidden('mechanism_id')->default(Admin::user()->id);
            $form->select('occupation_id')->required()->options(Occupation::getOccupationData());
            $form->display('created_at');
            $form->display('updated_at');
            $form->saving(function ($form) {
                if ($form->type == Constants::SINGLE_CHOICE) {
                    $data['A'] = $form->input('A');
                    $data['B'] = $form->input('B');
                    $data['C'] = $form->input('C');
                    $data['D'] = $form->input('D');
                    $form->answer_single_option = json_encode($data);
                }
                elseif($form->type == Constants::JUDGMENT){
                    $form->answer_single_option='';
                }
                $form->deleteInput('A');
                $form->deleteInput('B');
                $form->deleteInput('C');
                $form->deleteInput('D');
            });
        });
    }

}
