<?php


namespace App\Http\Requests;


class BaseDataRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->route()->uri) {
            case 'api/base-data/check-version':
                return [
                    'os'=>['required','integer'],
                    'name'=>['required'],
                ];
                break;
            case 'api/base-data/get-agreement':
                return [
                    'position'=>['integer'],
                    'title'=>['required']
                ];
                break;
            default:return [];
        }
    }

    public function attributes()
    {
        return [
            'os' => '系统',
            'name' => '名称',
            'position' => '位置',
        ];
    }

    public function messages()
    {
        switch ($this->route()->uri) {

            default:return [];
        }
    }
}
