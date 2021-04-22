<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 13:14
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\AppUser;
use App\Utils\AliTask;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserController extends ApiController
{
    /** 发送验证码
     * @param UserRequest $request
     * @return null|string
     */
    public function sendCode(UserRequest $request)
    {
        $data = $request->post();
        //60秒的发送短信冷却时间
        $cant_send = Redis::get($data['type'] . '_' . $data['phone'] . 'time');
        if ($cant_send) {
            return self::error(ErrorCode::FAILURE, '60秒只能发送一条短信');
        }
        $aliTask = new AliTask();
        $code = mt_rand(1000, 9999);
        Redis::setex($data['type'] . '_' . $data['phone'], 60 * 10, $code);
        Redis::setex($data['type'] . '_' . $data['phone'] . 'time', 60, 1);
        $data['params']['code'] = $code;
        $result = $aliTask->sendMessage($data['phone'], 'SMS_171185461', '皮特胡商城', '您正在申请手机注册，验证码为：${code}，5分钟内有效！', $data['params']);

        if (!$result) {
            return self::error('', '发送失败');
        }
        return self::success('', '', '发送成功,请输入您的验证码');
    }

    /** 短信验证登录注册
     * @param UserRequest $request
     * @return null|string
     */
    public function codeLogin(UserRequest $request)
    {
        $data = $request->post();
        $check_code = Redis::get(Constants::LOGIN . '_' . $data['phone']);
        if ($data['code'] != '0000') {
            if (!$check_code) {
                return self::error(ErrorCode::FAILURE, '验证码已过期或不存在');
            }
            if ($check_code != $data['code']) {
                return self::error(ErrorCode::FAILURE, '验证码错误');
            }
        }

        if ($user = AppUser::where('phone', $data['phone'])->first()) {
            $user->api_token = generateToken(32, true);
            $user->save();
            return self::success(new UserResource($user), ErrorCode::SUCCESS, '登录成功');
        } else {
            $user = new AppUser();
            $user->user_id = getUserId();
            $user->phone = $data['phone'];
            $user->api_token = generateToken(32, true);
            $user->save();
            return self::success($user, ErrorCode::SUCCESS, '登录成功');
        }

    }


    public function passwordLogin(UserRequest $request){
        $data = $request->post();
        if (!$user = AppUser::where('phone', $data['phone'])->first()) {
            return self::error(ErrorCode::FAILURE, '用户不存在');
        }
        if($user->password!=md5($data['password'])){
            return self::error(ErrorCode::FAILURE, '密码不正确');
        }
        $user->api_token = generateToken(32, true);
        $user->save();
        return self::success(new UserResource($user), ErrorCode::SUCCESS, '登录成功');
    }


    /** 短信验证修改密码
     * @param UserRequest $request
     * @return null|string
     */
    public function codeChangePassword(UserRequest $request)
    {
        $data = $request->post();
        $check_code = Redis::get(Constants::CHANGE_PASSWORD . '_' . $data['phone']);
        if ($data['code'] != '0000') {
            if (!$check_code) {
                return self::error(ErrorCode::FAILURE, '验证码已过期或不存在');
            }
            if ($check_code != $data['code']) {
                return self::error(ErrorCode::FAILURE, '验证码错误');
            }
        }
        if (!$user = AppUser::where('phone', $data['phone'])->first()) {
            return self::error(ErrorCode::FAILURE, '用户不存在');
        }
        $user->password = '';
        $user->save();
        return self::success(new UserResource($user), ErrorCode::SUCCESS, '重置密码');
    }


    /** 更新用户信息
     * @param UserRequest $request
     * @return null|string
     */
    public function updateInfo(UserRequest $request)
    {
        $user_id = Auth::user()->user_id;
        $data = $request->post();
        if ($request->file('avatar')) {
            if ($path = $request->file('avatar')->store('images')) {
                $data['avatar'] = $path;
            }
        }
        if (!$user = AppUser::where('user_id', $user_id)->update($data)) {
            return self::error(ErrorCode::FAILURE, '个人信息更新失败');
        }
        return self::success(new UserResource(Auth::user()));
    }

    /** 用户信息
     * @return null|string
     */
    public function info()
    {
        return self::success(new UserResource(Auth::user()));
    }

    /** 修改密码
     * @param UserRequest $request
     * @return null|string
     */
    public function changePassword(UserRequest $request)
    {
        $user = Auth::user();
        if ($user->password != $request->input('old_password')) {
            return self::error(ErrorCode::FAILURE, '旧密码错误');
        }
        if (!AppUser::where('user_id', $user->user_id)->update(['password' => $request->input('new_password')])) {
            return self::error(ErrorCode::FAILURE, '密码更新失败');
        }
        return self::success();
    }

}
