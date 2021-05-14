<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\HotSearch;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class HotSearchController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new HotSearch(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('words');
            $grid->column('count');
            $grid->column('sort');
            $grid->column('is_default')->switch()->help('用来展示在App首页的默认只取一个');
            $grid->column('status')->switch();
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
        return Show::make($id, new HotSearch(), function (Show $show) {
            $show->field('id');
            $show->field('words');
            $show->field('count');
            $show->field('sort');
            $show->field('is_default');
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
        return Form::make(new HotSearch(), function (Form $form) {
            $form->display('id');
            $form->text('words')->required();
            $form->number('count');
            $form->number('sort');
            $form->switch('is_default');
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
