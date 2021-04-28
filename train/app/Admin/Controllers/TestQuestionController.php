<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\ChooseQuestionBatch;
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
            if (Admin::user()->isRole('mechanism')) {
                $grid->model()->where('mechanism_id', Admin::user()->id);
            }
            $grid->column('id')->sortable();
            $grid->column('type')->display(function ($type) {
                return Constants::getQuestionType($type);
            });
            $grid->column('attributes')->display(function ($attributes) {
                return Constants::getQuestionAttributeType($attributes);
            });
            $grid->column('description');
            $grid->column('description_image')->image();
            $grid->column('选项')->display(function () {
                if ($this->type == Constants::SINGLE_CHOICE) {
                    return u2c($this->answer_single_option);
                } else {
                    return u2c($this->answer_judgment_option);
                }
            });
            $grid->column('答案')->display(function () {
                if ($this->type == Constants::SINGLE_CHOICE) {
                    return u2c($this->true_single_answer);
                } else {
                    return u2c($this->true_judgment_answer);
                }
            });
            $grid->column('mechanism_id')->display(function ($mechanism_id) {
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
            $show->field('type')->as(function ($type) {
                return Constants::getQuestionType($type);
            });;
            $show->field('attributes')->as(function ($attributes) {
                return Constants::getQuestionAttributeType($attributes);
            });
            $show->field('description');
            if ($show->model()->attributes == Constants::TEXT) {
                $show->field('description');
            } else {
                $show->field('description_image')->image();
            }
            $show->field('选项')->as(function () use ($show) {
                if ($show->model()->type == Constants::SINGLE_CHOICE) {
                    return u2c($show->model()->answer_single_option);
                } else {
                    return u2c($show->model()->answer_judgment_option);
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
            $form->select('attributes')->options(Constants::getQuestionAttributeItems())->when(Constants::TEXT, function ($form) {
                $form->textarea('description');
            })->when(Constants::IMAGE, function ($form) {
                $form->image('description_image');
            });
            $form->select('type')->options(Constants::getQuestionTypeItems())
                ->when(Constants::SINGLE_CHOICE, function ($form) {
                    $form->table('answer_single_option', function (NestedForm $table) {
                        $table->select('选项')->options(Constants::getSingleChoiceOptionItems());
                        $table->text('答案');
                    })->savingArray();
                    $form->select('true_single_answer')->options(Constants::getSingleChoiceOptionItems());
                })
                ->when(Constants::JUDGMENT, function ($form) {
                    $form->table('answer_judgment_option', function (NestedForm $table1) {
                        $table1->select('选项')->options(Constants::getJudgmentOptionItems());
                        $table1->text('答案');
                    })->savingArray();
                    $form->select('true_judgment_answer')->options(Constants::getJudgmentOptionItems());
                });

            if (Admin::user()->isRole('administrator')) {
                $form->select('mechanism_id')->options(Mechanism::getMechanismData());
            } elseif (Admin::user()->isRole('mechanism')) {
                $form->hidden('mechanism_id')->default(Admin::user()->id);
            }
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
