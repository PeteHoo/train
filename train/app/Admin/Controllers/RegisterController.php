<?php


namespace App\Admin\Controllers;


use App\Models\AdminRoleUser;
use App\Models\Agreement;
use App\Models\Region;
use App\Rules\IDCard;
use App\Rules\Mobile;
use App\Utils\AliTask;
use App\Utils\ApiResponse;
use App\Utils\Constants;
use App\Utils\ErrorCode;
use Dcat\Admin\Form;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\LazyWidget;
use DishCheng\YunXinSms\YunXinSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class RegisterController extends AdminController
{
    use ApiResponse;
    use LazyWidget;

    /** 主页
     * @param Content $content
     * @return Content.
     */
    public function home(Content $content){
        return $content
            ->header('首页')
            ->full()
            ->body(view('index'));
    }

    /** 注册页面
     * @param Content $content
     * @return Content
     */
    public function register(Content $content){
        return $content
            ->header('注册')
            ->full()
            ->body(view('register'));
    }

    /** 发送注册验证码
     * @param Request $request
     * @return null|string
     */
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

        if(Administrator::where('phone',$data['phone'])->first()){
            return self::error(ErrorCode::FAILURE,'您已经注册过了,去登录吧');
        }

        $code = mt_rand(1000, 9999);
        Redis::setex($data['phone'], 60 * 10, $code);
        Redis::setex($data['phone'].'time',60, 1);
        //阿里短信
        $aliTask = new AliTask();
        $data['params']['code'] = $code;
        $result = $aliTask->sendMessage($data['phone'],'SMS_171185461','皮特胡商城', '您正在申请手机注册，验证码为：${code}，5分钟内有效！', $data['params']);
        if (!$result) {
            return self::error('', '发送失败');
        }
        //网易云短信
//        $params = ['mobile' => $data['phone'], 'templateid' => '19475174', 'authCode' => $code];
//        $result=YunXinSms::code_post($params);
//        if ($result['code']!=200) {
//            return self::error(ErrorCode::FAILURE, '发送失败');
//        }
        return self::success($result['result'], '', '发送成功,请输入您的验证码');
    }

    /** 验证验证码通过注册
     * @param Request $request
     * @return null|string
     */
    public function verifyCode(Request $request){
        $data = $request->post();
        if($data['code']!='0000'){
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
        }

        return self::success('', ErrorCode::SUCCESS, '验证成功');
    }

    /** 忘记密码页面
     * @param Content $content
     * @return Content
     */
    public function forgotPassword(Content $content){
        return $content
            ->header('首页')
            ->full()
            ->body(view('forgot-password'));
    }

    /** 发送注册验证码
     * @param Request $request
     * @return null|string
     */
    public function sendFindPasswordCode(Request $request){
        $data = $request->post();
        if(!$data['phone']){
            return self::error(ErrorCode::FAILURE,'手机号为空');
        }
        if(!checkPhone($data['phone'])){
            return self::error(ErrorCode::FAILURE,'手机号格式不正确');
        }
        //60秒的发送短信冷却时间
        $cant_send=Redis::get('fp_'.$data['phone'].'time');
        if($cant_send){
            return self::error(ErrorCode::FAILURE,'60秒只能发送一条短信');
        }

        if(!Administrator::where('phone',$data['phone'])->first()){
            return self::error(ErrorCode::FAILURE,'不存在该账号');
        }
        $aliTask = new AliTask();
        $code = mt_rand(1000, 9999);
        Redis::setex('fp_'.$data['phone'], 60 * 10, $code);
        Redis::setex('fp_'.$data['phone'].'time',60, 1);
        $data['params']['code'] = $code;
        $result = $aliTask->sendMessage($data['phone'],'SMS_171185461','皮特胡商城', '您正在申请手机注册，验证码为：${code}，5分钟内有效！', $data['params']);

        if (!$result) {
            return self::error('', '发送失败');
        }
        return self::success($result['result'], '', '发送成功,请输入您的验证码');
    }

    /** 验证验证码通过注册
     * @param Request $request
     * @return null|string
     */
    public function verifyForgotPasswordCode(Request $request){
        $data = $request->post();
        if($data['code']!='0000'){
            if(!($data['code']??'')){
                return self::error(ErrorCode::FAILURE, '验证码不能为空');
            }
            $check_code = Redis::get('fp_'.$data['phone']);
            if (!$check_code) {
                return self::error(ErrorCode::FAILURE, '验证码已过期或不存在');
            }
            if ($check_code != $data['code']) {
                return self::error(ErrorCode::FAILURE, '验证码错误');
            }
        }
        return self::success('', ErrorCode::SUCCESS, '验证成功');
    }

    public function changePasswordPage(Content $content){
        $phone=request()->input('phone');
        $code=request()->input('code');
        return $content
            ->header('首页')
            ->full()
            ->body(view('change-password',['phone'=>$phone,'code'=>$code]));
    }

    public function changePassword(Request $request){
        $phone=$request->input('phone');
        $code=$request->input('code');
        $check_code=Redis::get('fp_'.$phone);

        if($code!='0000'){
            if(!$phone|!$code|!$check_code|$check_code != $code){
               return self::error(ErrorCode::PARAMETER_ERROR,'验证码错误');
            }
        }
        $password=request()->input('password');
        $confirm_password=request()->input('confirm_password');
        if(!$password){
            return self::error(ErrorCode::FAILURE, '密码不能为空');
        }
        if(strlen($password)<5){
            return self::error(ErrorCode::FAILURE, '密码至少要五位');
        }
        if($password!=$confirm_password){
            return self::error(ErrorCode::FAILURE, '两次密码不一致');
        }
        $admin=Administrator::where('phone',$phone)->first();
        if(!$admin){
            return self::error(ErrorCode::FAILURE, '不存在该用户');
        }
        $admin->password=bcrypt($password);
        return $admin->save()?self::success('',ErrorCode::SUCCESS,'密码修改成功'):
            self::error(ErrorCode::FAILURE,'修改失败');
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
        return $this->form()->saving(
            function ($form){
                $form->deleteInput('password_confirmation');
                $form->deleteInput('code');
                $form->password=bcrypt($form->password);
            }
        )->store();
    }

    public function form(){
        $phone=request()->input('phone');
        $code=request()->input('code');
        $check_code = Redis::get($phone);
        if($code!='0000'){
            if(!$phone|!$code|!$check_code|$check_code != $code){
                return redirect('admin/phone-register');
            }
        }
        return Form::make(new Administrator(), function (Form $form)use($phone,$code) {
            $form->title('注册');
            $form->action('register');
            $form->disableListButton();
            $form->multipleSteps()
                ->remember() // 记住表单步骤，默认不开启
                ->width('950px')
                ->add('账号注册',function ($step)use($phone,$code){
                    $step->hidden('username', '用户名')->default($phone);
                    $step->password('password', trans('admin.password'))->minLength(5)
                        ->maxLength(20)
                        ->customFormat(function ($v) {
                            if ($v == $this->password) {
                                return;
                            }
                            return $v;
                        })->rules('required',['required'=>'密码必填']);
                    $step->password('password_confirmation',  trans('admin.password_confirmation'))->same('password');
                    $step->hidden('phone', '手机号')->default($phone);
                    $step->hidden('code', '验证码')->default($code);
                })
                ->add('基本信息', function ($step) use($phone,$code){

                    $step->hidden('phone', '手机号')->default($phone);
                    $step->hidden('code', '验证码')->default($code);
                    $step->select('member_type', '会员类型')->options(Constants::getMemberItems())->rules('required',['required'=>'会员类型必填']);
                    // h5 表单验证
                    $step->text('company_name', '公司名称')->rules('required',['required'=>'公司名称必填']);
                    $step->text('social_code', '社会信用代码')->rules('required',['required'=>'社会信用代码必填']);
                    // 后端验证
                    $step->select('province', '省')->options(Region::getRegion())->rules('required',['required'=>'省必填'])->load('city','api-region');
                    $step->select('city', '市')->rules('required',['required'=>'市必填']);
                    $step->text('address', '地址')->rules('required',['required'=>'地址必填']);
                    $step->text('legal_person', '法人')->rules('required',['required'=>'法人必填']);
                    $step->text('legal_person_id_card', '法人身份证')->rules(['required',new IDCard()],['required'=>'法人身份证必填']);
                    $step->text('contact_name', '联系人姓名')->rules('required',['required'=>'联系人姓名必填']);
                    $step->tel('contact_phone', '联系人手机号')->rules(['required',new Mobile()],['required'=>'联系人手机号必填']);
                })
                ->add('财务信息', function ($step)use($phone,$code) {
                    $step->hidden('name', '名称');
                    $step->text('payee', '收款方')->readonly()->rules('required',['required'=>'收款方必填']);
                    $step->text('bank', '开户行')->rules('required',['required'=>'开户行必填']);
                    $step->text('bank_address', '开户行所在地')->rules('required',['required'=>'开户行所在地必填']);
                    $step->text('bank_account', '银行账户')->rules(['confirmed'],['confirmed'=>'两次银行账户不一致']);
                    $step->text('bank_account_confirmation', '银行账号（再次确认）')->rules('required',['required'=>'银行账号（再次确认）必填']);
                    $step->hidden('phone', '手机号')->default($phone);
                    $step->hidden('code', '验证码')->default($code);
                    // 事件

                    $step->shown(function () {
                        return <<<JS
    Dcat.info('财务信息');
    console.log('财务信息', args);
    var firstFormArray = args.getFormArray(1);
    var secondFormArray = args.getFormArray(1);
    console.log(secondFormArray);
    $( "input[name='payee']").val(firstFormArray[5]['value']);
    $( "input[name='name']").val(secondFormArray[4]['value']);
    JS;
                });

            })
            ->add('资质证明', function ($step) use($phone,$code) {
                  $step->hidden('phone', '手机号')->default($phone);
                    $step->hidden('code', '验证码')->default($code);
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
                $step->html(Agreement::where('title','免责声明')->where('position',Constants::BACKEND_SETTLE)->first()->content??'');
                $step->radio('is_permit','是否同意协议')->options([1=>'同意'])->rules('required',['required'=>'必须同意协议才能注册']);;
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
