<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\LearningMaterialChapter;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialDetail;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LearningMaterialChapterController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new LearningMaterialChapter(), function (Grid $grid) {
            $grid->model()->orderBy('id', 'DESC');
            if (Admin::user()->isRole('mechanism')) {
                $learning_materials = LearningMaterial::getLearningMaterialIds(Admin::user()->id);
                $grid->model()->whereIn('learning_material_id', $learning_materials);
            }
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('learning_material_id')->display(function ($learning_material_id) {
                return LearningMaterial::getLearningMaterialDataDetail($learning_material_id);
            });
            $grid->column('sort');
            $grid->column('status')->switch();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

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
                if (Admin::user()->isRole('mechanism')) {
                    $filter->equal('learning_material_id')->select(LearningMaterial::getAllLearningMaterialData(Admin::user()->id));
                } elseif (Admin::user()->isRole('administrator')) {
                    $filter->equal('learning_material_id')->select(LearningMaterial::getAllLearningMaterialData());
                }
                $filter->like('title');

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
        return Show::make($id, new LearningMaterialChapter(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('learning_material_id')->as(function ($learning_material_id) {
                return LearningMaterial::getLearningMaterialDataDetail($learning_material_id);
            });
            $show->field('sort');
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
        return Form::make(new LearningMaterialChapter(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->select('learning_material_id')->options(LearningMaterial::getAllLearningMaterialData(Admin::user()->id));
            $form->number('sort');
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');

            $form->saved(function ($form, $result) {
                if ($form->isEditing()) {
                    $result = $form->getKey();
                }
                if (Admin::user()->isRole('mechanism')) {
                    $learningMaterialChapter = \App\Models\LearningMaterialChapter::where('id', $result)->first();
                    $learning_material_id = $learningMaterialChapter->learning_material_id;
                    $learningMaterial = LearningMaterial::find($learning_material_id);
                    $learningMaterial->status = Constants::CLOSE;
                    $learningMaterial->save();
                }
            });
            $form->deleting(function (Form $form) {
                // 获取待删除行数据，这里获取的是一个二维数组
                $data = $form->model()->toArray();
                foreach ($data as $k=>$v){
                    if(LearningMaterialDetail::where('chapter_id',$v['id'])->count()){
                        return $form->response()
                            ->error($v['title'].'下还有课程详情不能删除');
                    }
                }
            });
        });
    }
}
