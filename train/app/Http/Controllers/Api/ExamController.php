<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 11:57
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\ExamRequest;
use App\Http\Resources\ExamAllDetailResource;
use App\Http\Resources\ExamCollectionPaginate;
use App\Models\Exam;
use App\Models\ExamScoreRecord;
use App\Models\Industry;
use App\Models\LearningMaterialRecord;
use App\Models\Mechanism;
use App\Models\Occupation;
use App\Models\TestQuestion;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends ApiController
{
    /** 上传成绩
     * @param ExamRequest $request
     * @return null|string
     */
    public function addRecord(ExamRequest $request)
    {
        $data = $request->post();
        $data['user_id'] = Auth::user()->user_id;
        if (!ExamScoreRecord::create($data)) {
            return self::error(ErrorCode::FAILURE);
        }
        return self::success();
    }

    /** 模拟考概况
     * @return null|string
     */
    public function records()
    {
        $all_score = ExamScoreRecord::where('user_id', Auth::user()->user_id)->sum('score')??0;
        $count = ExamScoreRecord::where('user_id', Auth::user()->user_id)->count();
        $duration = LearningMaterialRecord::where('user_id', Auth::user()->user_id)->sum('duration');
        if($count==0){
            $count=1;
        }
        $data['all_question_count'] = (int)(ExamScoreRecord::where('user_id', Auth::user()->user_id)->sum('question_count'));
        $data['average_score'] = $all_score / $count;
        $data['duration']=changeTimeType($duration);
        return self::success($data);
    }

    /** 试卷列表
     * @param ExamRequest $request
     * @return string|null
     */
    public function examList(ExamRequest $request)
    {
        if (!$occupation_id = json_decode(Auth::user()->occupation_id)) {
            return self::error(ErrorCode::FAILURE,'您还没有职业');
        }
        $query=Exam::where('status', Constants::OPEN)->whereIn('occupation_id', $occupation_id);
        if($post_occupation_id=$request->post('occupation_id')){
            $query->where('occupation_id',$post_occupation_id);
        }
        if($request->post('only_mechanism')&&$mechanism_id=Auth::user()->mechanism_id){
            $query->where('mechanism_id',$mechanism_id);
        }
        return self::success(new ExamCollectionPaginate($query->paginate($request->get('perPage'))));
    }

    public function examDetail(ExamRequest $request){
       $exam=Exam::where('status', Constants::OPEN)->where('id',$request->get('id'))->first();
       return self::success(new ExamAllDetailResource($exam));
    }

    public function randomExamDetail(ExamRequest $request){
        $only_mechanism=$request->get('only_mechanism');
        $occupation_id=$request->get('occupation_id');
        $occupation_ids=json_decode(Auth::user()->occupation_id);
        if(!in_array($occupation_id,(array)$occupation_ids)){
            return self::error(ErrorCode::FAILURE,'您没有该职业');
        }
        $occupation=Occupation::find($occupation_id);
        if(!$occupation){
            return self::error(ErrorCode::PARAMETER_ERROR,'该职业不存在');
        }
        $choice_question_num=$occupation->choice_question_num;
        $choice_question_score=$occupation->choice_question_score;
        $judgment_question_num=$occupation->judgment_question_num;
        $judgment_question_score=$occupation->judgment_question_score;
        $query_choice=TestQuestion::where('occupation_id',$occupation_id)
            ->where('type',Constants::SINGLE_CHOICE)
            ->orderBy(DB::raw('RAND()'))
            ->limit($choice_question_num);
        $query_judgment=TestQuestion::where('occupation_id',$occupation_id)
            ->where('type',Constants::JUDGMENT)
            ->orderBy(DB::raw('RAND()'))
            ->limit($judgment_question_num);
        if($only_mechanism&&$mechanism_id=Auth::user()->mechanism_id){
            $query_choice->where('mechanism_id',$mechanism_id);
            $query_judgment->where('mechanism_id',$mechanism_id);
        }
        $choice_result=$query_choice->get()->toArray();
        $query_judgment=$query_judgment->get()->toArray();
        if(count($choice_result)<$choice_question_num){
            return self::error(ErrorCode::FAILURE,'题库选择题数量不够无法生成');
        }
        if(count($query_judgment)<$judgment_question_num){
            return self::error(ErrorCode::FAILURE,'题库判断题数量不够无法生成');
        }
        $examDetail=array_merge((array)$choice_result,(array)$query_judgment);

        $data['name']=$occupation->name.'随机试题';
        $data['mechanism_id']=$mechanism_id??1;
        $data['industry_id']=$occupation->industry_id;
        $data['occupation_id']=$occupation->id;
        $data['mechanism']=Mechanism::getMechanismDataDetail($mechanism_id??1);
        $data['industry']=Industry::getIndustryDataDetail($occupation->industry_id);
        $data['occupation']=Occupation::getOccupationDataDetail($occupation->id);
        $data['choice_question_num']=$choice_question_num;
        $data['choice_question_score']=$choice_question_score;
        $data['judgment_question_num']=$judgment_question_num;
        $data['judgment_question_score']=$judgment_question_score;
        $data['exam_time']=$occupation->exam_time;
        $data['passing_grade']=$occupation->passing_grade;
        $data['score']=$choice_question_num*$choice_question_score+$judgment_question_num*$judgment_question_score;
        $data['question_count']=$choice_question_num+$judgment_question_num;
        $data['status']=Constants::OPEN;
        $data['created_at']=dateNow();
        $data['updated_at']=dateNow();
        $data['examDetail']=$examDetail;
        return self::success($data);
    }

}
