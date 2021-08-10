<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\LearningMaterialRecord;
use App\Models\LearningMaterialDetail;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LearningMaterialRecordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new LearningMaterialRecord(), function (Grid $grid) {
            $user_id=request()->get('user_id');
            $grid->model()->where('user_id',$user_id)->whereHas('learningMaterialDetail')->whereHas('appUser')->with(['learningMaterialDetail'])->with(['appUser'])->orderBy('id','DESC');
            $grid->column('id')->sortable();
            $grid->column('learningMaterialDetail.title','课程详情');
            $grid->column('appUser.name','用户');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableActions();

//            $grid->filter(function (Grid\Filter $filter) {
//                $filter->equal('id');
//            });
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
        return Show::make($id, new LearningMaterialRecord(), function (Show $show) {
//            $show->field('id');
//            $show->field('learning_material_detail_id');
//            $show->field('user_id');
//            $show->field('created_at');
//            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new LearningMaterialRecord(), function (Form $form) {
//            $form->display('id');
//            $form->text('learning_material_detail_id');
//            $form->text('user_id');
//
//            $form->display('created_at');
//            $form->display('updated_at');
        });
    }
}
