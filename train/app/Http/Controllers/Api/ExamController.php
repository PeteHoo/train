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
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Illuminate\Support\Facades\Auth;

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
        $all_score = ExamScoreRecord::where('user_id', Auth::user()->user_id)->sum('score');
        $count = ExamScoreRecord::where('user_id', Auth::user()->user_id)->count();
        $data['all_question_count'] = (int)(ExamScoreRecord::where('user_id', Auth::user()->user_id)->sum('question_count'));
        $data['average_score'] = ($all_score / $count) ?? '0';
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
        return self::success(new ExamCollectionPaginate($query->paginate($request->get('perPage'))));
    }


    public function examDetail(ExamRequest $request){
       $exam=Exam::where('status', Constants::OPEN)->where('id',$request->get('id'))->first();
       return self::success(new ExamAllDetailResource($exam));
    }

}
