<?php


namespace App\Admin\Controllers;



use App\Http\Controllers\Api\RegionController;
use App\Models\Region;
use App\Rules\IDCard;
use App\Rules\Mobile;
use App\Utils\AliTask;
use App\Utils\ApiResponse;
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
        if(\Dcat\Admin\Models\Administrator::where('phone',$data['phone'])->first()){
            return self::error(ErrorCode::FAILURE,'该手机号已注册');
        }
        $aliTask = new AliTask();
        $code = mt_rand(1000, 9999);
        Redis::setex($data['phone'], 60 * 5, $code);
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


    public function form(){

        return Form::make(new Administrator(), function (Form $form) {
            $form->title('注册');
            $form->action('register');
            $form->disableListButton();
            $form->multipleSteps()
                ->remember() // 记住表单步骤，默认不开启
                ->width('950px')
                ->add('基本信息', function ($step) {
                   // $info = '<i class="fa fa-exclamation-circle"></i> 表单字段支持前端验证和后端验证混用，前端验证支持H5表单验证以及自定义验证。';

                   // $step->html(Alert::make($info)->info());

                    $step->hidden('username', '用户名')->default(15728006876);
                    $step->hidden('password', '密码')->default(15728006876);
                    $step->hidden('name', '名称')->default(15728006876);
                    $step->hidden('phone', '手机号')->default(15728006876);
                    $step->select('member_type', '会员类型')->options([1=>'机构',2=>'企业'])->required();
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
                    $step->text('payee', '收款方')->disable()->required();
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
                $step->file('business_picture', '营业执照')->url('file-register')->required();
                $step->file('bank_permit_picture', '银行许可照片')->url('file-register')->required();
            })
            ->done(function () use ($form) {
      
                $data = [
                    'title'       => '审核',
                    'description' => '请等待平台管理员审核',
                ];

                return view('done-step', $data);
            });
    });

    }

}
