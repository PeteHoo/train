<?php

namespace App\Admin\Controllers;


use App\Admin\Repositories\UpdatePlan;
use App\Models\AppName;
use App\Models\Version;
use App\Utils\Constants;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Traits\LazyWidget;

class UpdatePlanController extends AdminController
{
    use LazyWidget;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new UpdatePlan(), function (Grid $grid) {
            $grid->model()->orderBy('id','DESC');
            $grid->column('id')->sortable();
            $grid->column('name')->display(function ($name){
                return AppName::getAppNameDetail($name);
            });
            $grid->column('md5');
//            $grid->column('download_link')->display(function ($download_link){
//                return "<a>".getImageUrl($download_link)."</a>";
//            });
            $grid->column('description');
            $grid->column('after_version')->display(function ($after_version){
               return Version::getVersionDetail($after_version);
            });
            $grid->column('before_version')->display(function ($before_version){
                return Version::getVersionDetails(explode(',',$before_version));
            });
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
        return Show::make($id, new UpdatePlan(), function (Show $show) {
            $show->field('id');
            $show->field('name')->as(function ($name){
                return Constants::getAppType($name);
            });;
            $show->field('md5');
            $show->field('download_link');
            $show->field('description');
            $show->field('after_version')->as(function ($after_version){
                return Version::getVersionDetail($after_version);
            });
            $show->field('before_version')->as(function ($before_version){
                return Version::getVersionDetails(json_decode($before_version,true));
            });;
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
        return Form::make(new UpdatePlan(), function (Form $form) {
            $form->display('id');
            $form->select('name')->required()->options(AppName::getAppNameData())->loads(['after_version','before_version'], ['api-version','api-version']);
            $form->text('md5');
            $form->file('download_link')->maxSize(1024*500);
            $form->textarea('description');
            $form->select('after_version');
            $form->multipleSelect('before_version')->saving(function ($before_version){
                return implode(',',$before_version);
            });
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
