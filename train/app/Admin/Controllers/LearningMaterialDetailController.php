<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\LearningMaterialDetail;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialChapter;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LearningMaterialDetailController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new LearningMaterialDetail(), function (Grid $grid) {
            if(Admin::user()->isRole('mechanism')){
                $learning_materials=LearningMaterial::getLearningMaterialIds(Admin::user()->id);
                $grid->model()->whereIn('learning_material_id',$learning_materials);
            }
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('chapter_id')->display(function ($chapter_id){
                return LearningMaterialChapter::getLearningMaterialChapterDataDetail($chapter_id);
            });
            $grid->column('description');
            $grid->column('video')->display(function ($video){
                if($video){
                    return '<div class="lake-form-media-row-img"><video style="width:200px;height: 100px"controls="controls" width="100%" height="100%" src="'.config('app.file_url').$video.'"></video>';
                }else{
                    return '';
                }
            });
            $grid->column('sort');
            $grid->column('duration');
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
        return Show::make($id, new LearningMaterialDetail(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('chapter_id')->as(function ($chapter_id){
                return LearningMaterialChapter::getLearningMaterialChapterDataDetail($chapter_id);
            });
            $show->field('description');
            $show->field('video')->file();
            $show->field('sort');
            $show->field('duration');
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
        return Form::make(new LearningMaterialDetail(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            if(Admin::user()->isRole('administrator')){
                $form->select('learning_material_id')->options(LearningMaterial::getLearningMaterialData())->load('chapter_id','api-chapter');
            }elseif(Admin::user()->isRole('mechanism')){
                $form->select('learning_material_id')->options(LearningMaterial::getLearningMaterialData(Admin::user()->id))->load('chapter_id','api-chapter');
            }
            $form->select('chapter_id');
            $form->text('description');
            $form->file('video');
            $form->number('sort');
            $form->time('duration')->default(0);
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
