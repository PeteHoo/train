<?php

namespace App\Admin\Controllers;

use App\Models\Region;
use App\Utils\Constants;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Repositories\Administrator;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MechanismController extends AdminController
{

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Administrator(), function (Grid $grid) {
            $grid->model()->where('id','>',1);
            $grid->column('id')->sortable();
            $grid->column('username');
            $grid->column('member_type')->display(function ($member_type){
                return Constants::getMemberType($member_type);
            });
            $grid->column('phone');
            $grid->column('province')->display(function ($province){
                return Region::getRegionById($province);
            });
            $grid->column('city')->display(function ($city){
                return Region::getRegionById($city);
            });
            $grid->column('address');
            $grid->column('legal_person');
            $grid->column('legal_person_id_card');
            $grid->column('payee');
            $grid->column('bank');
            $grid->column('bank_address');
            $grid->column('is_permit')->display(function ($is_permit){
                return Constants::getStatusType($is_permit);
            });
            $grid->column('status')->display(function ($is_permit){
                return Constants::getStatusType($is_permit);
            });
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }
    public function show($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['show'] ?? trans('admin.show'))
            ->body($this->detail($id));
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
        return Show::make($id, new Administrator(), function (Show $show) {
            $show->field('id');
            $show->field('username');
            $show->field('name');
            $show->field('avatar')->image();
            $show->field('phone');
            $show->field('member_type')->as(function ($member_type){
                return Constants::getMemberType($member_type);
            });
            $show->field('company_name');
            $show->field('social_code');
            $show->field('province')->as(function ($province){
                return Region::getRegionById($province);
            });
            $show->field('city')->as(function ($city){
                return Region::getRegionById($city);
            });
            $show->field('address');
            $show->field('legal_person');
            $show->field('legal_person_id_card');
            $show->field('contact_name');
            $show->field('contact_phone');
            $show->field('payee');
            $show->field('bank');
            $show->field('bank_address');
            $show->field('bank_account');
            $show->field('business_picture')->image();
            $show->field('bank_permit_picture')->image();
            $show->field('is_permit')->as(function ($is_permit){
                return Constants::getStatusType($is_permit);
            });
            $show->field('status')->as(function ($status){
                return Constants::getStatusType($status);
            });;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Administrator(), function (Form $form) {
            if(Admin::user()->isRole('administrator')){
                $form->switch('status')->options(Constants::getStatusItems());
            }
            $form->password('old_password', trans('admin.old_password'));
            $form->password('password', trans('admin.password'))
                ->minLength(5)
                ->maxLength(20)
                ->customFormat(function ($v) {
                    if ($v == $this->password) {
                        return;
                    }
                    return $v;
                });
            $form->password('password_confirmation', trans('admin.password_confirmation'))->same('password');
            $form->ignore(['password_confirmation', 'old_password']);
            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }

                if (! $form->password) {
                    $form->deleteInput('password');
                }
            });
        });
    }


    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id));
    }


    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['create'] ?? trans('admin.create'))
            ->body($this->form());
    }


    public function update($id)
    {
        return $this->form()->update($id);
    }


    public function store()
    {
        return $this->form()->store();
    }


    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }

}
