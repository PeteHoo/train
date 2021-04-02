<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Mechanism;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MechanismController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Mechanism(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('social_credit_code');
            $grid->column('address');
            $grid->column('deposit_bank');
            $grid->column('bank_card_number');
            $grid->column('legal_person');
            $grid->column('id_card');
            $grid->column('phone');
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
        return Show::make($id, new Mechanism(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('social_credit_code');
            $show->field('address');
            $show->field('deposit_bank');
            $show->field('bank_card_number');
            $show->field('legal_person');
            $show->field('id_card');
            $show->field('phone');
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
        return Form::make(new Mechanism(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('social_credit_code');
            $form->text('address');
            $form->text('deposit_bank');
            $form->text('bank_card_number');
            $form->text('legal_person');
            $form->text('id_card');
            $form->text('phone');
            $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
