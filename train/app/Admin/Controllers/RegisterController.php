<?php


namespace App\Admin\Controllers;



use App\Utils\AliTask;
use App\Utils\ApiResponse;
use App\Utils\ErrorCode;
use Dcat\Admin\Form;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Repositories\Administrator;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RegisterController extends AdminController
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
        if(!$data['phone']){
            return self::error(ErrorCode::FAILURE,'手机号为空');
        }
        $aliTask = new AliTask();
        $code = mt_rand(1000, 9999);
        Redis::setex($data['phone'], 60 * 5, $code);
        $data['params']['code'] = $code;
        $result = $aliTask->sendMessage($data['phone'],'SMS_171185461','皮特胡商城', '您正在申请手机注册，验证码为：${code}，5分钟内有效！', $data['params']);
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


    public function form(){
        return Form::make(new Administrator(), function (Form $form) {
            $form->title('注册');
            $form->action('step');
            $form->disableListButton();
            $form->multipleSteps()
                ->remember() // 记住表单步骤，默认不开启
                ->width('950px')
                ->add('基本信息', function ($step) {
                   // $info = '<i class="fa fa-exclamation-circle"></i> 表单字段支持前端验证和后端验证混用，前端验证支持H5表单验证以及自定义验证。';

                   // $step->html(Alert::make($info)->info());

                    $step->radio('member_type', '会员类型')->options([1=>'机构',2=>'企业'])->required();
                    // h5 表单验证
                    $step->text('company_name', '公司名称')
                        ->required();


                    $step->text('social_code', '社会信用代码')->required();

                    // 后端验证
                    $step->text('province', '省')
                        ->required();

                    $step->text('city', '市')
                        ->required();

                    $step->text('address', '地址')
                        ->required();

                    $step->text('legal_person', '法人')
                    ->required();

                    $step->text('legal_person_id_card', '法人身份证')
                        ->required();

                    $step->text('contact_name', '手机号')
                        ->required();

                    $step->text('contact_phone', '收款方')
                        ->required();
                })
                ->add('财务信息', function ($step) {
                    $step->tags('hobbies', '爱好')
                        ->options(['唱', '跳', 'RAP', '踢足球'])
                        ->required();

                    $step->text('books', '书籍');
                    $step->text('music', '音乐');

                    // 事件
                    $step->shown(function () {
                        return <<<JS
    Dcat.info('兴趣爱好');
    console.log('兴趣爱好', args);
    JS;
                });

            })
            ->add('地址', function ($step) {
                $step->text('address', '街道地址');
                $step->text('post_code', '邮政编码');
                $step->tel('tel', ' 联系电话');
            })
            ->done(function () use ($form) {
                $resource = $form->getResource(0);

                $data = [
                    'title'       => '操作成功',
                    'description' => '恭喜您成为第10086位用户',
                    'createUrl'   => $resource,
                    'backUrl'     => $resource,
                ];

                return view('admin::form.done-step', $data);
            });
    });

    }

}
