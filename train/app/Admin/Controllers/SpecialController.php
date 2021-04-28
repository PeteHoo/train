<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Special;
use App\Models\Industry;
use App\Models\LearningMaterial;
use App\Models\Occupation;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class SpecialController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Special(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('occupation_id')->display(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $grid->column('material_ids')->display(function ($material_ids) {
                $material_ids = json_decode($material_ids);
                $material_ids_str='';
                foreach ($material_ids as $k => $v) {
                    $material_ids_str .= ((LearningMaterial::find($v)->title ?? '') . '/');
                }
                return $material_ids_str;
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
        return Show::make($id, new Special(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('occupation_id')->as(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $show->field('material_ids')->as(function ($material_ids) {
                $material_ids = explode(',', $material_ids);
                $material_ids_str = '';
                foreach ($material_ids as $k => $v) {
                    $material_ids_str .= LearningMaterial::find($v)->title ?? '' . '/';
                }
                return $material_ids_str;
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
        return Form::make(new Special(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->select('occupation_id')->options(Occupation::getOccupationData())->required();
            $form->multipleSelect('material_ids')->options(LearningMaterial::getLearningMaterialData())->savingArray();
            $form->switch('status');
            $form->number('sort');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
