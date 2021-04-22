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
                    'type' => ['required', 'integer'],
                    'phone' => ['required', new Mobile()],
                ];
                break;
            case 'api/user/code-login':
                return [
                    'phone' => ['required', new Mobile()],
                    'code' => ['required'],
                ];
                break;
            case 'api/user/change-password':
                return [
                    'new_password' => ['required'],
                ];
                break;
            case 'api/user/code-change-password':
                return [
                    'phone' => ['required'],
                    'code' => ['required'],
                ];
                break;

            default;
                return [];
        }
    }

    public function attributes()
    {
        return [
            'type' => '短信类型',
            'phone' => '手机号',
            'code' => '验证码',
            'old_password' => '旧密码',
            'new_password' => '新密码',
        ];
    }

    public function messages()
    {

        switch ($this->route()->uri) {
            case 'api/user/code-change-password':
                return [
                    'new_password.required' => '新密码不能为空',
                    'phone.required' => '手机号不能为空',
                    'code.required' => '验证码不能为空'
                ];
                break;
            default;
                return [];
        }
    }
}
