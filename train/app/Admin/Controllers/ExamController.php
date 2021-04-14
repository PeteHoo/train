<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Exam;
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
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('mechanism_id');
            $grid->column('industry_id');
            $grid->column('occupation_id');
            $grid->column('score');
            $grid->column('question_count');
            $grid->column('status');
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
        return Show::make($id, new Exam(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('mechanism_id');
            $show->field('industry_id');
            $show->field('occupation_id');
            $show->field('score');
            $show->field('question_count');
            $show->field('status');
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
        return Form::make(new Exam(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('mechanism_id');
            $form->text('industry_id');
            $form->text('occupation_id');
            $form->text('score');
            $form->text('question_count');
            $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
