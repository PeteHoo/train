<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ExamScoreRecord;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ExamScoreRecordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ExamScoreRecord(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('exam_id');
            $grid->column('score');
            $grid->column('question_count');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableCreateButton();
            $grid->disableEditButton();
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
        return Show::make($id, new ExamScoreRecord(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('exam_id');
            $show->field('score');
            $show->field('question_count');
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
        return Form::make(new ExamScoreRecord(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('exam_id');
            $form->text('score');
            $form->text('question_count');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
