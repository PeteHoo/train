<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\LearningMaterial;
use App\Models\Industry;
use App\Models\LearningMaterialChapter;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LearningMaterialController extends AdminController
{

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    protected function grid()
    {
        return Grid::make(new LearningMaterial(), function (Grid $grid) {
            $grid->model()->orderBy('id','DESC');
            if (Admin::user()->isRole('mechanism')) {
                $grid->model()->where('mechanism_id', Admin::user()->id);
            }
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('description')->display(function ($description){
                return mb_chunk_split($description,15,"<br>");
            });
            $grid->column('mechanism_id')->display(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('industry_id')->display(function ($industry_id) {
                return Industry::getIndustryDataDetail($industry_id);
            });
            $grid->column('occupation_id')->display(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });

            $grid->column('picture')->image(config('app.cdn_file_url'));
            $grid->column('is_open')->if(function ($column) {
                if ($this->mechanism_id != Admin::user()->id) {
                    $column->display(function ($status) {
                        return Constants::getStatusType($status);
                    });
                } else {
                    $column->switch();
                }
            });

            if (Admin::user()->isRole('mechanism')) {
                $grid->column('status')->help('需要平台审核')->display(function ($status) {
                    return Constants::getStatusType($status);
                });
                $grid->column('sort');
            } elseif (Admin::user()->isRole('administrator')) {
                $grid->column('status')->switch();
                $grid->column('sort')->editable();
            }

//            $grid->column('created_at');
//            $grid->column('updated_at')->sortable();
            $grid->actions(function ($actions){
                if (Admin::user()->isRole('administrator')) {
                    if($actions->row->mechanism_id!=1){
                        $actions->disableEdit();
                    }
                }
            });
            $grid->filter(function (Grid\Filter $filter) {
                if (Admin::user()->isRole('administrator')) {
                    $filter->equal('mechanism_id')->select(Mechanism::getMechanismData());
                }
                $filter->equal('industry_id')->select(Industry::getIndustryData())->load('occupation_id', 'api-occupation');
                $filter->equal('occupation_id')->select(Occupation::getOccupationData());
                $filter->equal('is_open')->select(Constants::getStatusItems());
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
            $show->field('mechanism_id')->as(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $show->field('industry_id')->as(function ($industry_id) {
                return Industry::getIndustryDataDetail($industry_id);
            });
            $show->field('occupation_id')->as(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $show->field('picture')->image(config('app.cdn_file_url'));
            $show->field('is_open')->as(function ($status) {
                return Constants::getStatusType($status);
            });
            $show->field('status')->as(function ($status) {
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
        return Form::make(new LearningMaterial(), function (Form $form) {
            $form->display('id');
            $form->text('title')->maxLength(15);
            $form->textarea('description');
            $form->hidden('mechanism_id')->default(Admin::user()->id);
            $form->select('industry_id')->options(Industry::getIndustryData())->load('occupation_id', 'api-occupation')->required();
            $form->select('occupation_id')->required();
            $form->image('picture');  //可删除

            if (Admin::user()->isRole('mechanism')) {
                $form->switch('is_open');
            } elseif (Admin::user()->isRole('administrator')) {
                $form->hidden('is_open')->default(Constants::OPEN);
            }
            $form->hidden('status')->default(Constants::CLOSE);
            $form->hidden('sort')->default(0);

            $form->display('created_at');
            $form->display('updated_at');

            $form->deleting(function (Form $form) {
                // 获取待删除行数据，这里获取的是一个二维数组
                $data = $form->model()->toArray();
                foreach ($data as $k=>$v){
                    if(LearningMaterialChapter::where('learning_material_id',$v['id'])->count()){
                        return $form->response()
                            ->error($v['title'].'下还有章节不能删除');
                    }
                }
            });
        });
    }
}
