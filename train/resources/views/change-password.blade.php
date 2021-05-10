<style>
    .login-box {
        margin-top: -10rem;
        padding: 5px;
    }
    .login-card-body {
        padding: 1.5rem 1.8rem 1.6rem;
    }
    .card, .card-body {
        border-radius: .25rem
    }
    .login-btn {
        padding-left: 2rem!important;;
        padding-right: 1.5rem!important;
    }
    .content {
        overflow-x: hidden;
    }
    .form-group .control-label {
        text-align: left;
    }
</style>

<div class="login-page bg-40">
    <div class="login-box">
        <div class="login-logo mb-2">
            {{ config('admin.name').'修改密码' }}
        </div>
        <div class="card">
            <div class="card-body login-card-body shadow-100">
                <a href="/admin/home"><i class="feather icon-chevron-left"></i></a>
                <p class="login-box-msg mt-1 mb-1">{{ __('admin.change_password') }}</p>

                <form method="POST">
                    <input type="hidden" name="phone" value="{{ $phone }}"/>
                    <input type="hidden" name="code" value="{{ $code }}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input
                                type="password"
                                class="form-control"
                                name="password"
                                placeholder="{{ trans('admin.password') }}"
                                value=""
                                required
                                autofocus
                        >

                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>

                        <label for="password">{{ trans('admin.password') }}</label>

                        <div class="help-block with-errors"></div>
                    </fieldset>
                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input
                                type="password"
                                class="form-control"
                                name="confirm_password"
                                placeholder="{{ trans('admin.password_confirmation') }}"
                                value=""
                                required
                                autofocus
                        >

                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>

                        <label for="password">{{ trans('admin.password_confirmation') }}</label>

                        <div class="help-block with-errors"></div>
                    </fieldset>

                    <span onclick="changePassword()" class="btn btn-primary float-right">

                        {{ __('admin.change_password') }}
                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </span>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function changePassword() {
        var phone=$( "input[name='phone']").val();
        var code=$( "input[name='code']").val();
        var password=$( "input[name='password']").val();
        var confirm_password=$( "input[name='confirm_password']").val();
        $.ajax({
            url:"change-password",
            async:false,
            method:'post',
            data:{
                phone:phone ,
                code:code,
                password:password,
                confirm_password:confirm_password
            },
            success:function(res){
                if(res.code==200){
                    Dcat.info(res.message);
                    setInterval("window.location.href='/admin/auth/login'",1000);
                }
                else if(res.code==220){
                    Dcat.info(res.message);
                    setInterval("window.location.href='/admin/forgot-password'",1000);
                }else{
                    Dcat.info(res.message);
                }
            }});
    }


</script>
