<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
    // 自定义登录view模板
    protected $view = 'login';


    public function getLogin(Content $content)
    {
        if ($this->guard()->check()) {
            return redirect($this->getRedirectPath());
        }
        return $content->full()->body(view($this->view));
    }


    /**
     * Handle a login request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {

        $credentials = $request->only([$this->username(), 'password']);
        $remember = (bool) $request->input('remember', false);



        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            $this->username()   => 'required',
            'password'          => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorsResponse($validator);
        }
        $admin=Administrator::where('username',$credentials['username'])->first();
        if($admin){
            if(!$admin->status){
                return $this->response()
                    ->error('该账号还未通过审核')
                    ->send();
            }
        }


        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return $this->validationErrorsResponse([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    public function getLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $path = admin_url('home');
        if ($request->pjax()) {
            return "<script>location.href = '$path';</script>";
        }

        return redirect($path);
    }
}
