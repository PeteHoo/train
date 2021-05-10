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
            {{ config('admin.name') }}
        </div>
        <div class="card">

            <div class="card-body login-card-body shadow-100">
                <a href="/admin/home"><i class="feather icon-chevron-left"></i></a>
                <p class="login-box-msg mt-1 mb-1">{{ __('admin.register') }}</p>

                <form id="login-form" method="POST">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input
                            type="text"
                            class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            name="phone"
                            placeholder="{{ trans('admin.phone') }}"
                            value="{{ old('phone') }}"
                            required
                            autofocus
                        >

                        <div class="form-control-position">
                            <i class="feather icon-user"></i>
                        </div>

                        <label for="phone">{{ trans('admin.phone') }}</label>

                        <div class="help-block with-errors"></div>
                        @if($errors->has('phone'))
                            <span class="invalid-feedback text-danger" role="alert">
                                            @foreach($errors->get('phone') as $message)
                                    <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i> {{$message}}</span><br>
                                @endforeach
                                        </span>
                        @endif
                    </fieldset>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input
                            minlength="5"
                            maxlength="20"
                            id="code"
                            type="code"
                            class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                            name="code"
                            placeholder="{{ trans('admin.code') }}"

                            autocomplete="current-code"
                        >

                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                        <label for="code">{{ trans('admin.code') }}</label>

                        <div class="help-block with-errors"></div>
                        @if($errors->has('code'))
                            <span class="invalid-feedback text-danger" role="alert">
                                            @foreach($errors->get('code') as $message)
                                    <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i> {{$message}}</span><br>
                                @endforeach
                                            </span>
                        @endif

                    </fieldset>
                    <span onclick="sendCode()" class="btn btn-primary float-left">

                        {{ __('admin.send_code') }}
                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </span>
                    <span onclick="verifyCode()" class="btn btn-primary float-right">

                        {{ __('admin.register') }}
                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </span>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function sendCode() {
        $.ajax({
            url:"send-code",
            async:false,
            method:'post',
            data:{
                phone:$( "input[name='phone']").val() ,
            },
            success:function(res){
                Dcat.info(res.message);
            }});
    }
    function verifyCode() {
        var phone=$( "input[name='phone']").val();
        var code=$( "input[name='code']").val();
        $.ajax({
            url:"verify-code",
            async:false,
            method:'post',
            data:{
                phone:phone ,
                code:code
            },
            success:function(res){
                if(res.code==200){
                    window.location.href='/admin/register/create?phone='+phone+'&code='+code;
                }else{
                    Dcat.info(res.message);
                }
            }});
    }
</script>
