<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\LearningMaterial;
use App\Models\Industry;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Utils\Constants;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LearningMaterialController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new LearningMaterial(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('description');
            $grid->column('industry_id')->display(function ($industry_id){
                return Industry::getIndustryDataDetail($industry_id);
            });
            $grid->column('occupation_id')->display(function ($occupation_id){
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $grid->column('mechanism_id')->display(function ($mechanism_id){
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('video');
            $grid->column('status')->switch();
            $grid->column('sort')->editable();
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
        return Show::make($id, new LearningMaterial(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('description');
            $show->field('industry_id');
            $show->field('occupation_id');
            $show->field('mechanism_id');
            $show->field('video');
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
        return Form::make(new LearningMaterial(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->textarea('description');
            $form->select('industry_id')->options(Industry::getIndustryData())->load('occupation_id', 'api-occupation');
            $form->select('occupation_id');
            $form->select('mechanism_id')->options(Mechanism::getMechanismData());
            $form->file('video')->accept('mp4,mov');
            $form->switch('status');
            $form->number('sort');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
