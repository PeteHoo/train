<?php
/**
 * Created by PhpStorm.
 * User: 35304
 * Date: 2021/5/8
 * Time: 23:02
 */

namespace App\Admin\Table;


use App\Models\Occupation;
use App\Models\TestQuestion;
use App\Utils\Constants;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class TestQuestionTable extends LazyRenderable
{

    /**
     * 创建表格.
     *
     * @return Grid
     */
    public function grid(): Grid
    {
        // TODO: Implement grid() method.
        $mechanism_id = $this->mechanism_id;
        $type=$this->type;
        $occupation_id=$this->occupation_id;
        dd($occupation_id);
        if($type==Constants::SINGLE_CHOICE){
            $count=Occupation::find($occupation_id)->choice_question_num??0;
        }
        if($type==Constants::JUDGMENT){
            $count=Occupation::find($occupation_id)->judgment_question_num??0;
        }

        return Grid::make(new TestQuestion(), function (Grid $grid)use($type,$mechanism_id,$count) {
            $grid->model()
                ->where('type',$type)
                ->where('mechanism_id',$mechanism_id);
            $grid->column('id');
            $grid->column('type');
            $grid->column('description','题目');
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->quickSearch(['id', 'description']);

            $grid->paginate(10);
            $grid->disableActions();
            $grid->tools('<span class="d-none d-sm-inline">题目数量'.$count.'</span>');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('description','题目');
            });
        });
    }
}