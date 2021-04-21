<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 11:57
 */

namespace App\Http\Controllers\Api;


use App\Models\Exam;
use App\Models\ExamScoreRecord;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends ApiController
{
    /** 上传成绩
     * @param Request $request
     * @return null|string
     */
    public function addRecord(Request $request)
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

    /**
     * 试卷列表
     */
    public function examList()
    {
        $query = Exam::where('status', Constants::OPEN);
        if ($occupation_id = Auth::user()->occupation_id) {
            $query->where('occupation_id', $occupation_id);
        }else{
            $query->where('occupation_id', 0);
        }
       return self::success($query->get());

    }

}
