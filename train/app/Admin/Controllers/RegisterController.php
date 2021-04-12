<?php


namespace App\Admin\Controllers;


use App\Models\AdminRoleUser;
use App\Models\Region;
use App\Rules\Mobile;
use App\Utils\AliTask;
use App\Utils\ApiResponse;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Dcat\Admin\Form;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Repositories\Administrator;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Traits\LazyWidget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class RegisterController extends AdminController
{
    use ApiResponse;
    use LazyWidget;

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
        if(!checkPhone($data['phone'])){
            return self::error(ErrorCode::FAILURE,'手机号格式不正确');
        }
        //60秒的发送短信冷却时间
        $cant_send=Redis::get($data['phone'].'time');
        if($cant_send){
            return self::error(ErrorCode::FAILURE,'60秒只能发送一条短信');
        }

        if(\Dcat\Admin\Models\Administrator::where('phone',$data['phone'])->first()){
            return self::error(ErrorCode::FAILURE,'该手机号已注册');
        }
        $aliTask = new AliTask();
        $code = mt_rand(1000, 9999);
        Redis::setex($data['phone'], 60 * 10, $code);
        Redis::setex($data['phone'].'time',60, 1);
        $data['params']['code'] = $code;
        $result = $aliTask->sendMessage($data['phone'],'SMS_171185461','皮特胡商城', '您正在申请手机注册，验证码为：${code}，5分钟内有效！', $data['params']);

        if (!$result) {
            return self::error('', '发送失败');
        }
        return self::success($result['result'], '', '发送成功,请输入您的验证码');
    }

    public function verifyCode(Request $request){
        $data = $request->post();
        if(!($data['code']??'')){
            return self::error(ErrorCode::FAILURE, '验证码不能为空');
        }
        $check_code = Redis::get($data['phone']);
        if (!$check_code) {
            return self::error(ErrorCode::FAILURE, '验证码已过期或不存在');
        }
        if ($check_code != $data['code']) {
            return self::error(ErrorCode::FAILURE, '验证码错误');
        }
        return self::success('', ErrorCode::SUCCESS, '验证成功');
    }


    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->full()
            ->body($this->form());
    }

    public function store()
    {
        return $this->form()->store();
    }

    public function form(){
        $phone=request()->input('phone');
        $code=request()->input('code');
        $check_code = Redis::get($phone);

//        if(!$phone|!$code|!$check_code|$check_code != $code){
//
//        }

        return Form::make(new Administrator(), function (Form $form)use($phone) {
            $form->title('注册');
            $form->action('register');
            $form->disableListButton();
            $form->multipleSteps()
                ->remember() // 记住表单步骤，默认不开启
                ->width('950px')
                ->add('账号注册',function ($step)use($phone){
                    $step->hidden('username', '用户名')->default($phone);
                    $step->password('password', '密码')->rules('confirmed');
                    $step->password('password_confirmation', '确认密码');
                })
                ->add('基本信息', function ($step) use($phone){
                    $step->hidden('name', '名称')->default($phone);
                    $step->hidden('phone', '手机号')->default($phone);
                    $step->select('member_type', '会员类型')->options(Constants::getMemberItems())->required();
                    // h5 表单验证
                    $step->text('company_name', '公司名称')
                        ->required();


                    $step->text('social_code', '社会信用代码')->required();

                    // 后端验证
                    $step->select('province', '省')->options(Region::getRegion())
                        ->required()->load('city','api-region');

                    $step->select('city', '市')
                        ->required();

                    $step->text('address', '地址')
                        ->required();

                    $step->text('legal_person', '法人')
                    ->required();

                    $step->text('legal_person_id_card', '法人身份证')
                        ->required();
                    //->rules([new IDCard()])

                    $step->tel('contact_name', '联系人姓名')
                        ->required();

                    $step->text('contact_phone', '联系人手机号')->rules([new Mobile()])
                        ->required();
                })
                ->add('财务信息', function ($step) {
                    $step->text('payee', '收款方')->readonly()->required();
                    $step->text('bank', '开户行')->required();
                    $step->text('bank_address', '开户行所在地')->required();
                    $step->text('bank_account', '银行账户')->required()->rules('confirmed');
                    $step->text('bank_account_confirmation', '银行账号（再次确认）')->required();
                    // 事件

                    $step->shown(function () {
                        return <<<JS
    Dcat.info('财务信息');
    console.log('财务信息', args);
    var firstFormArray = args.getFormArray(0);
    $( "input[name='payee']").val(firstFormArray[6]['value']);
    JS;
                });

            })
            ->add('资质证明', function ($step) {
                $step->file('business_picture', '营业执照')->url('file-register')->on('startUpload', <<<JS
        function () {
            // 上传文件前附加自定义参数到文件上传接口
            this.uploader.options.formData['phone'] =$(" input[ name='phone' ] ").val();
        }
JS
                );
                $step->file('bank_permit_picture', '银行许可照片')->url('file-register')->on('startUpload', <<<JS
        function () {
            // 上传文件前附加自定义参数到文件上传接口
            this.uploader.options.formData['phone'] =$(" input[ name='phone' ] ").val();
        }
JS
                );
            })
            ->done(function () use ($form) {

                    $adminRoleUser=new AdminRoleUser();
                    $adminRoleUser->role_id=2;
                    $adminRoleUser->user_id=$form->getKey();
                    $adminRoleUser->save();

                $data = [
                    'title'       => '审核',
                    'description' => '请等待平台管理员审核',
                ];

                return view('done-step', $data);
            });
    });

    }

}
