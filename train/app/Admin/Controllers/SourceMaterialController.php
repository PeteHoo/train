<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\SourceMaterial;
use App\Utils\Constants;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class SourceMaterialController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SourceMaterial(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('picture')->image();
            $grid->column('type')->display(function ($type){
                return Constants::getSourceMaterialType($type);
            });
            $grid->column('file_url')->if(function ($column){
                if($this->type==Constants::PICTURE){
                    $column->display(function ($file_url) {
                        return '<image style="width:200px;height: 100px"  src="'.config('app.cdn_file_url').$file_url.'">';

                    });
                }elseif($this->type==Constants::VIDEO){
                    $column->display(function ($file_url) {
                        if($file_url){
                            return '<div class="lake-form-media-row-img"><video style="width:200px;height: 100px"controls="controls" width="100%" height="100%" src="'.config('app.cdn_file_url').$file_url.'"></video>';
                        }else{
                            return '';
                        }
                    });
                }else{
                    return $column;
                }
            });
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
        return Show::make($id, new SourceMaterial(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('picture')->image();
            $show->field('type')->as(function ($type){
                return Constants::getSourceMaterialType($type);
            });;
            $show->field('file_url');
            $show->field('status')->as(function ($status){
                return Constants::getStatusType($status);
            });;
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
        return Form::make(new SourceMaterial(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->image('picture');
            if($form->isCreating()){
                $form->select('type')->options(Constants::getSourceMaterialItems());
                $form->file('file_url');
            }elseif($form->isEditing()){
                $form->hidden('type');
                $form->file('file_url');
            }
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
