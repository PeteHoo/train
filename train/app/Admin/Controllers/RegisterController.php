<?php


namespace App\Admin\Controllers;


use App\Utils\AliTask;
use App\Utils\ApiResponse;
use App\Utils\ErrorCode;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{
    use ApiResponse;

    public function register(Content $content){
        return $content
            ->header('注册')
            ->full()
            ->body(view('register'));
    }

    public function sendCode(Request $request){
        $data = $request->post();
        $aliTask = new AliTask();
        $code = mt_rand(1000, 9999);
        Redis::setex($data['phone'], 60 * 5, $code);
        $data['params']['code'] = $code;
        $result = $aliTask->sendMessage($data['phone'],$data['template'], $data['sign'], $data['ep'], $data['params']);
        if (!$result) {
            return self::error('', '发送失败');
        }

        return self::success($result['result'], '', '发送成功');
    }

    public function verifyCode(Request $request){
        $data = $request->post();
        $check_code = Redis::get($data['phone']);
        if (!$check_code) {
            return self::error(ErrorCode::FAILURE, '验证码已过期或不存在');
        }
        if ($check_code != $data['code']) {
            return self::error(ErrorCode::FAILURE, '验证码错误');
        }
        return self::success('', ErrorCode::SUCCESS, '验证成功');
    }
}
