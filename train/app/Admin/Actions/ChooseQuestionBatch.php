<?php


namespace App\Admin\Actions;


use App\Models\Exam;
use App\Models\ExamDetail;
use App\Models\Occupation;
use App\Utils\Constants;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

class ChooseQuestionBatch extends BatchAction
{
    protected $title;

    protected $exam_id;

    protected $type;

    public function __construct($exam_id=0,$type=0)
    {
       $this->exam_id=$exam_id;
       $this->type=$type;
       if($this->type==Constants::SINGLE_CHOICE){
           $this->title='选择选择题';
       }elseif($this->type==Constants::JUDGMENT){
           $this->title='选择判断题';
       }
    }

    public function confirm()
    {
        return '您确定要添加已选中的题目吗？';
    }

    public function handle(Request $request)
    {
        $exam_id = $request->get('exam_id');
        $type = $request->get('type');
        // 获取主键
        $keys = $this->getKey();
        $occupation_id=Exam::find($exam_id)->occupation_id;
        $question_num=0;
        $has_count=0;
        if($type==Constants::SINGLE_CHOICE){
            $question_num=Occupation::find($occupation_id)->choice_question_num;
            $has_count=ExamDetail::where('exam_id',$exam_id)->where('type',$type)->count();
        }elseif($type==Constants::JUDGMENT){
            $question_num=Occupation::find($occupation_id)->judgment_question_num;
            $has_count=ExamDetail::where('exam_id',$exam_id)->where('type',$type)->count();
        }
        if(($question_num-$has_count)<count($keys)){
            return $this->response()
                ->error($type==Constants::SINGLE_CHOICE?'选择题数量已经超出':'判断题数量已经超出');
        }

        foreach ($keys as $k=>$v){
//            if(!ExamDetail::where('exam_id',$exam_id)->where('question_id',$v)->first()){
                $examDetail=new ExamDetail();
                $examDetail->exam_id=$exam_id;
                $examDetail->question_id=$v;
                $examDetail->sort=0;
                $examDetail->type=$type;
                $examDetail->save();
//            }
        }
        return $this->response()
            ->success('添加成功')->refresh();
    }



    // 设置请求参数
    public function parameters()
    {
        return [
            'exam_id' => $this->exam_id,
            'type'=>$this->type
        ];
    }


}
