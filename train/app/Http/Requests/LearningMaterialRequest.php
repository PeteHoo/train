<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 15:56
 */

namespace App\Http\Requests;


class LearningMaterialRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->route()->uri) {
            case 'api/learning-material/list':
                return [
                    'perPage'=>['integer'],
                    'page'=>['integer'],
                    'occupation_id'=>['integer']
                ];
                break;
            case 'api/learning-material/detail':
                return [
                    'id'=>['required'],
                ];
                break;
            case 'api/learning-material/search':
                return [
                    'search_word'=>['required'],
                ];
                break;
            case 'api/learning-material/recommend':
                return [
                    'id'=>['required'],
                    'occupation_id'=>['required'],
                    'perPage'=>['integer'],
                    'page'=>['integer'],
                ];
                break;
            case 'api/learning-material/record':
                return [
                    'learning_material_detail_id'=>['required'],
                    'duration'=>['required']
                ];
                break;
            case 'api/learning-material/add-view-count':
                return [
                    'detail_id'=>['required'],
                ];
                break;
            case 'api/learning-material/record-list':
                return [
                    'perPage'=>['integer'],
                    'page'=>['integer'],
                ];
                break;
            default:return [];
        }
    }

    public function attributes()
    {
        return [
            'perPage'=>'一页几个',
            'page'=>'第几页'
        ];
    }

    public function messages()
    {
        return [];
    }
}
