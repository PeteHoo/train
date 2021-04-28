<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Industry;
use App\Models\Mechanism;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class IndustryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Industry(), function (Grid $grid) {
            if(Admin::user()->isRole('mechanism')){
                $grid->model()->where('mechanism_id',Admin::user()->id);
            }

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('mechanism_id')->display(function ($mechanism_id){
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('status')->switch();
            $grid->column('sort');
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
        return Show::make($id, new Industry(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('mechanism_id')->as(function ($mechanism_id){
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $show->field('status');
            $show->field('sort');
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
        return Form::make(new Industry(), function (Form $form) {
            $form->display('id');
            $form->text('name');

            if(Admin::user()->isRole('administrator')){
                $form->select('mechanism_id')->options(Mechanism::getMechanismData());
            }elseif(Admin::user()->isRole('mechanism')){
                $form->hidden('mechanism_id')->default(Admin::user()->id);
            }
            $form->switch('status');
            $form->number('sort')->default(0);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
