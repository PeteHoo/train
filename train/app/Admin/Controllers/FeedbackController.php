<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Feedback;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class FeedbackController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Feedback(['appUser']), function (Grid $grid) {
            $grid->model()->orderBy('id','DESC');
            $grid->column('id')->sortable();
            $grid->column('appUser.name');
            $grid->column('title');
            $grid->column('description')->display(function ($description){
                return mb_chunk_split($description, 15, "<br>");
            });
            $grid->column('phone');
            $grid->column('created_at');
//            $grid->column('updated_at')->sortable();
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
        return Show::make($id, new Feedback(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('title');
            $show->field('description');
            $show->field('phone');
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
        return Form::make(new Feedback(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('title');
            $form->text('description');
            $form->text('phone');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
