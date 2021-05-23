<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ChangeTestQuestionFailRowAction;
use App\Admin\Actions\ChangeTestQuestionRowAction;
use App\Admin\Repositories\TestQuestion;
use App\Models\ExamDetail;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
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
            $grid->model()->orderBy('id', 'DESC');
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
            $grid->column('temp_description')->display(function ($temp_description) {
                return mb_chunk_split($temp_description, 15, "<br>");
            });
            $grid->column('临时选项')->display(function () {
                if ($this->type == Constants::JUDGMENT) {
                    return '';
                }
                return json_decode($this->temp_answer_single_option) ?? '';
            });
            $grid->column('临时答案')->display(function () {
                if ($this->type == Constants::SINGLE_CHOICE) {
                    return $this->temp_true_single_answer;
                } else {
                    return $this->temp_true_judgment_answer;
                }
            });
            $grid->column('mechanism_id')->display(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('occupation_id')->display(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $grid->column('is_open')->display(function ($status) {
                return Constants::getStatusType($status);
            });
            $grid->column('temp_is_open')->display(function ($status) {
                return Constants::getStatusType($status);
            });

            $grid->column('status')->help('需要平台审核')->display(function ($status) {
                return Constants::getVerifyType($status);
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('type')->select(Constants::getQuestionTypeItems());
                if (Admin::user()->isRole('administrator')) {
                    $filter->equal('mechanism_id')->select(Mechanism::getMechanismData());
                }
                $filter->equal('occupation_id')->select(Occupation::getOccupationData());
                $filter->like('description');

            });
            $grid->actions(function ($actions) {
                if (Admin::user()->isRole('administrator')) {
                    if ($actions->row->mechanism_id != 1) {
                        if ($actions->row->status == Constants::VERIFYING||$actions->row->status == Constants::INIT) {
                            $actions->append(new ChangeTestQuestionRowAction());
                            $actions->append(new ChangeTestQuestionFailRowAction());
                        }
                        $actions->disableEdit();
                    }
                }
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
            $show->field('is_open')->display(function ($status) {
                return Constants::getStatusType($status);
            });
            $show->field('temp_is_open')->display(function ($status) {
                return Constants::getStatusType($status);
            });
            $show->field('status')->display(function ($status) {
                return Constants::getVerifyType($status);
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
            $form->multipleImage('description_image')->limit(4)->savingArray();
            $form->hidden('answer_single_option');
            //新增时候可以选类型
            if ($form->isCreating()) {
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
                        } else {
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
            } //编辑时候不可以选类型
            elseif ($form->isEditing()) {
                $form->hidden('type');
                if ($form->model()->type == Constants::SINGLE_CHOICE) {
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
                    } else {
                        $form->text('A')->placeholder('请输入答案');
                        $form->text('B')->placeholder('请输入答案');
                        $form->text('C')->placeholder('请输入答案');
                        $form->text('D')->placeholder('请输入答案');
                    }
                    $form->select('true_single_answer')->options(Constants::getSingleChoiceOptionItems());
                } elseif ($form->model()->type == Constants::JUDGMENT) {
                    $form->select('true_judgment_answer')->options(Constants::getJudgmentOptionItems());
                }
            }
            $form->hidden('mechanism_id')->default(Admin::user()->id);
            $form->select('occupation_id')->required()->options(Occupation::getOccupationData());
            $form->switch('is_open')->default(Constants::OPEN);
            if (Admin::user()->isRole('mechanism')) {
                if($form->isCreating()){
                    $form->hidden('status')->default(Constants::INIT);
                }elseif($form->isEditing()){
                    $form->hidden('status')->default(Constants::VERIFYING);
                }
            } elseif (Admin::user()->isRole('administrator')) {
                $form->hidden('status')->default(Constants::VERIFIED);
            }
            //临时存储
            $form->hidden('temp_is_open');
            $form->hidden('temp_description');
            $form->hidden('temp_description_image');
            $form->hidden('temp_answer_single_option');
            $form->hidden('temp_true_single_answer');
            $form->hidden('temp_true_judgment_answer');

            $form->display('created_at');
            $form->display('updated_at');
            $form->saving(function ($form) {
                if ($form->type == Constants::SINGLE_CHOICE) {
                    $data['A'] = $form->input('A');
                    $data['B'] = $form->input('B');
                    $data['C'] = $form->input('C');
                    $data['D'] = $form->input('D');
                    $form->answer_single_option = json_encode($data);
                } elseif ($form->type == Constants::JUDGMENT) {
                    $form->answer_single_option = '';
                }
                if (Admin::user()->isRole('mechanism')) {
                    $form->temp_is_open = $form->is_open;
                    $form->temp_description = $form->description;
                    $form->temp_description_image = $form->description_image;
                    $form->temp_answer_single_option = $form->answer_single_option;
                    $form->temp_true_single_answer = $form->true_single_answer;
                    $form->temp_true_judgment_answer = $form->true_judgment_answer;

                    $form->deleteInput('is_open');
                    $form->deleteInput('description');
                    $form->deleteInput('description_image');
                    $form->deleteInput('answer_single_option');
                    $form->deleteInput('true_single_answer');
                    $form->deleteInput('true_judgment_answer');

                    if($form->isCreating()){
                        $form->status = Constants::INIT;
                    }elseif($form->isEditing()){
                        $form->status = Constants::VERIFYING;
                    }
                }
                $form->deleteInput('A');
                $form->deleteInput('B');
                $form->deleteInput('C');
                $form->deleteInput('D');
            });

            $form->deleted(function (Form $form, $result) {
                // 获取待删除行数据，这里获取的是一个二维数组
                $dataArray = $form->model()->toArray();
                // 通过 $result 可以判断数据是否删除成功
                if (!$result) {
                    return $form->response()->error('数据删除失败');
                }
                foreach ($dataArray as $key => $value) {
                    ExamDetail::where('question_id', $value['id'])->delete();
                }
                // 返回删除成功提醒，此处跳转参数无效
                return $form->response()->success('删除成功');
            });
        });
    }

}
