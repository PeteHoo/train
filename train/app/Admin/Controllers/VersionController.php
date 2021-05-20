<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Version;
use App\Models\AppName;
use App\Utils\Constants;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class VersionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Version(), function (Grid $grid) {
            $grid->model()->orderBy('id','DESC');
            $grid->column('id')->sortable();
            $grid->column('name')->display(function ($name){
                return AppName::getAppNameDetail($name);
            });
            $grid->column('os')->display(function ($os){
                return Constants::getOsType($os);
            });
            $grid->column('version_code');
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
        return Show::make($id, new Version(), function (Show $show) {
            $show->field('id');
            $show->field('name')->as(function ($name){
                return AppName::getAppNameDetail($name);
            });
            $show->field('os')->as(function ($os){
                return Constants::getOsType($os);
            });
            $show->field('version_code');
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
        return Form::make(new Version(), function (Form $form) {
            $form->display('id');
            $form->select('name')->options(AppName::getAppNameData());
            $form->select('os')->options(Constants::getOsItems());
            $form->text('version_code');
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
