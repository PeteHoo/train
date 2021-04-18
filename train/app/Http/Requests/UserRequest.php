<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 13:16
 */

namespace App\Http\Requests;


use App\Rules\Mobile;

class UserRequest extends BaseRequest
{
    public function rules()
    {
        switch ($this->route()->uri) {
            case 'api/user/send-code':
                return [
                    'phone'=>['required',new Mobile()],
                ];
                break;
            case 'api/user/code-login':
                return [
                    'phone'=>['required',new Mobile()],
                    'code'=>['required'],
                ];
                break;
            case 'api/user/change-password':
                return [
                    'new_password'=>['required'],
                ];
                break;
            default;return [];
        }
    }

    public function attributes()
    {
        return [
            'phone' => '手机号',
            'code' => '验证码',
            'old_password'=>'旧密码',
            'new_password'=>'新密码',
        ];
    }

    public function messages()
    {
        return [];
    }
}