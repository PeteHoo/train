<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Exhibition;
use App\Models\LearningMaterial;
use App\Utils\Constants;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ExhibitionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Exhibition(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('type')->display(function ($type){
                return Constants::getExhibitionType($type);
            });
            $grid->column('href_way')->display(function ($href_way){
                return Constants::getHrefWayType($href_way);
            });
            $grid->column('material_id')->display(function ($material_id){
                return LearningMaterial::getLearningMaterialDataDetail($material_id);
            });
            $grid->column('link');
            $grid->column('status')->display(function ($status){
                return Constants::getStatusType($status);
            });
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
        return Show::make($id, new Exhibition(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('type')->as(function ($type){
                return Constants::getExhibitionType($type);
            });
            $show->field('href_way')->as(function ($href_way){
                return Constants::getHrefWayType($href_way);
            });;
            $show->field('material_id')->as(function ($material_id){
                return LearningMaterial::getLearningMaterialDataDetail($material_id);
            });
            $show->field('link');
            $show->field('status')->as(function ($status){
                return Constants::getStatusType($status);
            });
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
        return Form::make(new Exhibition(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->select('type')->options(Constants::getExhibitionItems());
            $form->select('href_way')->options(Constants::getHrefWayItems());
            $form->select('material_id')->options(LearningMaterial::getLearningMaterialData());
            $form->url('link');
            $form->switch('status');
            $form->number('sort');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
