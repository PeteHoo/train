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
        $occupation=Occupation::find($occupation_id);
        if($type==Constants::SINGLE_CHOICE){
            $count=$occupation->choice_question_num??0;
        }
        if($type==Constants::JUDGMENT){
            $count=$occupation->judgment_question_num??0;
        }

        return Grid::make(new TestQuestion(), function (Grid $grid)use($type,$mechanism_id,$occupation_id,$count) {
                $grid->model()->where('type',$type)
                    ->where('occupation_id',$occupation_id)
                    ->where(function ($query)use($mechanism_id){
                        $query->where(function ($query)use($mechanism_id){
                            $query->where('mechanism_id','<>',$mechanism_id)->where('is_open',Constants::OPEN);
                        })->orWhere(function ($query)use($mechanism_id){
                            $query->where('mechanism_id',$mechanism_id);
                        });
                    });

            $grid->column('id');
            $grid->column('type');
            $grid->column('description','题目');
            $grid->column('选项')->display(function () {
                if ($this->type == Constants::JUDGMENT) {
                    return '';
                }
                return json_decode($this->answer_single_option) ?? '';
            });
            $grid->column('答案')->display(function () {
                if ($this->type == Constants::SINGLE_CHOICE) {
                    return $this->true_single_answer;
                } else {
                    return $this->true_judgment_answer;
                }
            });
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->quickSearch(['id', 'description']);

            $grid->paginate(10);
            $grid->disableActions();
            $grid->tools('<span class="d-none d-sm-inline">可选'.$count.'题</span>');
        });
    }
}
