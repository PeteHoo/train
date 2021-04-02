<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Agreement;
use App\Utils\Constants;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AgreementController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Agreement(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('position')->display(function ($position){
                return Constants::getAgreementType($position);
            });
            //$grid->column('content');
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
        return Show::make($id, new Agreement(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('position')->as(function ($position){
                return Constants::getAgreementType($position);
            });;
            $show->field('content')->unescape();
            $show->field('status')->as(function ($status){
                return Constants::getStatusType($status);
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
        return Form::make(new Agreement(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->select('position')->options(Constants::getAgreementItems());
            $form->editor('content');
            $form->switch('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
