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
            case 'api/exam/list':
                return [
                    'perPage'=>['integer'],
                    'page'=>['integer'],
                    'occupation_id'=>['integer']
                ];
                break;
            case 'api/exam/detail':
                return [
                    'id'=>['required','integer'],
                ];
                break;
            case 'api/exam/random':
                return [
                    'is_platform'=>['required','integer'],
                    'occupation_id'=>['required','integer'],
                ];
                break;

            default:return [];
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
            case 'api/exam/list':
                return [
                    'perPage.integer'=>'一页几个必须是整型',
                    'page.integer'=>'第几页必须是整型',
                ];
                break;
            case 'api/exam/detail':
                return [
                    'id.required'=>'id必填',
                    'id.integer'=>'id必须是整型',
                ];
                break;
            default:return [];
        }
    }
}
