<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 12:00
 */

namespace App\Http\Requests;


class ExamRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->route()->uri) {
            case 'api/exam/add-record':
                return [
                    'exam_id'=>['required','integer'],
                    'score'=>['required','integer'],
                    'question_count'=>['required','integer'],
                ];
                break;
            default;
        }
    }

    public function attributes()
    {
        return [
            'exam_id' => '试卷',
            'score' => '分数',
            'question_count' => '题目总数',
        ];
    }

    public function messages()
    {
        switch ($this->route()->uri) {
            case 'api/exam/add-record':
                return [
                    'exam_id.integer'=>'试卷格式不正确',
                    'score.integer'=>'分数格式不正确',
                    'question_count.integer'=>'题目总数格式不正确',
                ];
                break;
            default:return [];
        }
    }
}