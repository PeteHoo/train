<?php

namespace App\Admin\Controllers;

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

            if (Admin::user()->isRole('mechanism')) {
                $grid->model()->where('mechanism_id', Admin::user()->id);
            }
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('name');
            $grid->column('nick_name');
            $grid->column('phone');
            $grid->column('sex')->display(function ($sex) {
                return Constants::getSexType($sex);
            });
            $grid->column('birthday');
            $grid->column('attribute');
            $grid->column('avatar')->image();
            $grid->column('mechanism_id')->display(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });
            $grid->column('industry_id')->display(function ($industry_id) {
                return Industry::getIndustryDataDetail($industry_id);
            });
            $grid->column('occupation_id')->display(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
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
        return Show::make($id, new AppUser(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('name');
            $show->field('phone');
            $show->field('sex')->as(function ($sex) {
                return Constants::getSexType($sex);
            });
            $show->field('birthday');
            $show->field('attribute');
            $show->field('avatar')->image();
            $show->field('mechanism_id')->as(function ($mechanism_id) {
                return Mechanism::getMechanismDataDetail($mechanism_id);
            });;
            $show->field('industry_id')->as(function ($industry_id) {
                return Industry::getIndustryDataDetail($industry_id);
            });
            $show->field('occupation_id')->as(function ($occupation_id) {
                return Occupation::getOccupationDataDetail($occupation_id);
            });
            $show->field('status')->as(function ($status) {
                return Constants::getStatusType($status);
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
            $form->select('industry_id')->options(Industry::getIndustryData())->load('occupation_id', 'api-occupation');
            $form->select('occupation_id')->options(Occupation::getOccupationData());
            $form->text('phone');
            $form->password('password');
            $form->switch('status');
            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function ($form) {
                if ($form->isCreating()) {
                    $form->user_id = getOrderId();
                }
                $form->password = md5($form->password);
            });
        });
    }
}