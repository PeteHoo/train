<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\LearningMaterialDetail;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialChapter;
use App\Models\Occupation;
use App\Utils\Constants;
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
            $grid->model()->with('learningMaterial')->orderBy('id','DESC');
            if(Admin::user()->isRole('mechanism')){
                $learning_materials=LearningMaterial::getLearningMaterialIds(Admin::user()->id);
                $grid->model()->whereIn('learning_material_id',$learning_materials);
            }
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('chapter_id')->display(function ($chapter_id){
                return LearningMaterialChapter::getLearningMaterialChapterDataDetail($chapter_id);
            });
//            $grid->column('description');
            $grid->column('video')->display(function ($video){
                if($video){
                    return '<div class="lake-form-media-row-img"><video style="width:200px;height: 100px"controls="controls" width="100%" height="100%" src="'.config('app.cdn_file_url').$video.'"></video>';
                }else{
                    return '';
                }
            });
            $grid->column('sort');
            $grid->column('duration')->display(function (){
                return changeTimeType(get_duration_params(($this->video)));
            });
            $grid->column('status')->switch();

            $grid->actions(function ($actions) {
                if (Admin::user()->isRole('administrator')) {
                    if($actions->row->learningMaterial){
                    if ($actions->row->learningMaterial->mechanism_id != 1) {
                        $actions->disableEdit();
                    }
                    }
                }
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title');
                if(Admin::user()->isRole('mechanism')){
                    $filter->equal('learning_material_id')->select(LearningMaterial::getAllLearningMaterialData(Admin::user()->id))->load('chapter_id','api-chapter');

                }elseif(Admin::user()->isRole('administrator')){
                    $filter->equal('learning_material_id')->select(LearningMaterial::getAllLearningMaterialData())->load('chapter_id','api-chapter');
                }
                $filter->equal('chapter_id')->select();
                $filter->equal('learningMaterial.occupation_id','职业')->select(Occupation::getOccupationData());
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
            $show->field('status');
            $show->field('duration')->as(function (){
                return changeTimeType(get_duration_params(($this->video)));
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
        return Form::make(new LearningMaterialDetail(), function (Form $form) {
            $form->display('id');
            $form->text('title')->required();
            $form->select('learning_material_id')->required()->options(LearningMaterial::getAllLearningMaterialData(Admin::user()->id))->load('chapter_id','api-chapter');
            $form->select('chapter_id')->required();
//            $form->hidden('description');
            $form->file('video')->url('file-material')->maxSize(1024*2*1024)->required();
            $form->number('sort')->default(0);
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');
            $form->saved(function ($form, $result) {
                if ($form->isEditing()) {
                    $result = $form->getKey();
                }
                if (Admin::user()->isRole('mechanism')) {
                $learningMaterialDetail = \App\Models\LearningMaterialDetail::where('id',$result)->first();
                $learning_material_id = $learningMaterialDetail->learning_material_id;
                $learningMaterial = LearningMaterial::find($learning_material_id);
                $learningMaterial->status = Constants::CLOSE;
                $learningMaterial->save();
                }
            });
        });
    }
}
