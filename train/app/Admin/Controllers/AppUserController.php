<?php

namespace App\Admin\Controllers;


use App\Admin\Actions\CancelMechanismRowAction;
use App\Admin\Actions\ChangeMechanismFailRowAction;
use App\Admin\Actions\ChangeMechanismRowAction;
use App\Admin\Repositories\AppUser;
use App\Models\Industry;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AppUserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppUser(), function (Grid $grid) {
            $grid->model()->orderBy('id','DESC');
            if (Admin::user()->isRole('mechanism')) {
                $grid->model()->where('mechanism_id', Admin::user()->id)->orWhere('temp_mechanism_id',Admin::user()->id);
                $grid->disableDeleteButton();
                $grid->disableBatchDelete();
                $grid->actions(function ($actions) {
                    if($actions->row->mechanism_id==Admin::user()->id)
                        $actions->append(new CancelMechanismRowAction());
                });

            }
            $grid->column('id')->sortable();
//            $grid->column('user_id');
            $grid->column('name');
            $grid->column('nick_name');
            $grid->column('phone');
            $grid->column('sex')->display(function ($sex) {
                return Constants::getSexType($sex);
            });
            $grid->column('birthday');
            $grid->column('attribute')->display(function ($attribute){
                return Constants::getAttributeType($attribute);
            });
            $grid->column('avatar')->image();
            $grid->column('mechanism_id')->display(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('temp_mechanism_id')->display(function ($temp_mechanism_id) {
                return Mechanism::getMechanismDataDetail($temp_mechanism_id);
            });
            $grid->column('industry_id')->display(function ($industry_id) {
                $industry_id = json_decode($industry_id);
                $industry_id_result = '';
                if ($industry_id) {
                    foreach ($industry_id as $v) {
                        $industry_id_result .= Industry::getIndustryDataDetail($v) . '/';
                    }
                }
                return $industry_id_result;
            });
            $grid->column('occupation_id')->display(function ($occupation_id) {
                $occupation_id = json_decode($occupation_id);
                $occupation_id_result = '';
                if ($occupation_id) {
                    foreach ($occupation_id as $v) {
                        $occupation_id_result .= Occupation::getOccupationDataDetail($v) . '/';
                    }
                }
                return $occupation_id_result;
            });
//            $grid->column('created_at');
//            $grid->column('updated_at')->sortable();
            $grid->actions(function ($actions) {
                if (Admin::user()->isRole('mechanism')) {
                if($actions->row->status==Constants::VERIFYING) {
                    $actions->append(new ChangeMechanismRowAction());
                    $actions->append(new ChangeMechanismFailRowAction());
                }
                }
                if (Admin::user()->isRole('administrator')) {
                    if($actions->row->mechanism_id!=1){
                        $actions->disableEdit();
                    }
                }
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('name');
                $filter->equal('attribute')->select(Constants::getAttributeItems());
                if (Admin::user()->isRole('administrator')) {
                    $filter->equal('mechanism_id')->select(Mechanism::getMechanismData());
                }
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
        return Show::make($id, new AppUser(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('name');
            $show->field('phone');
            $show->field('sex')->as(function ($sex) {
                return Constants::getSexType($sex);
            });
            $show->field('birthday');
            $show->field('attribute')->as(function ($attribute){
                return Constants::getAttributeType($attribute);
            });
            $show->field('avatar')->image();
            $show->field('mechanism_id')->as(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $show->field('industry_id')->as(function ($industry_id) {
                return Industry::getIndustryDataDetail($industry_id);
            });
            $show->field('occupation_id')->as(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $show->field('status')->as(function ($status) {
                return Constants::getVerifyType($status);
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
        return Form::make(new AppUser(), function (Form $form) {
            $form->display('id');

            if (Admin::user()->isRole('administrator')) {
                $form->select('mechanism_id')->options(Mechanism::getMechanismData())->load('industry_id', 'api-industry');
            } elseif (Admin::user()->isRole('mechanism')) {
                $form->select('mechanism_id')->options(Mechanism::getMechanismData())->default(Admin::user()->id)->readOnly()->load('industry_id', 'api-industry');
            }
            $form->hidden('user_id');
            $form->text('name');
            $form->multipleSelect('industry_id')->options(Industry::getIndustryData())->savingArray()->load('occupation_id', 'api-occupation');
            $form->multipleSelect('occupation_id')->options(Occupation::getOccupationData())->savingArray();
            $form->mobile('phone')->required();
            $form->password('password');
            $form->select('status')->options(Constants::getVerifyItems());
            $form->display('created_at');
            $form->display('updated_at');
            $form->saving(function ($form) {
                if ($form->isCreating()) {
                    $form->user_id = getUserId();
                }
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = md5($form->password);
                }
                if (!$form->password) {
                    $form->deleteInput('password');
                }
                if ($form->status == Constants::OPEN) {
                    if ($form->temp_mechanism_id && $form->model()->mechanism_id != $form->temp_mechanism_id) {
                        $form->mechanism_id = $form->temp_mechanism_id;
                    }
                }
            });
        });
    }
}
