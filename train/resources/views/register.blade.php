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
                <p class="login-box-msg mt-1 mb-1">{{ __('admin.register') }}</p>

                <form id="login-form" method="POST" action="{{ admin_url('auth/register') }}">

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
                    <button onclick="sendCode()" class="btn btn-primary float-left login-btn">

                        {{ __('admin.send_code') }}
                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-primary float-right login-btn">

                        {{ __('admin.register') }}
                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    Dcat.ready(function () {
        // ajax表单提交
        $('#login-form').form({
            validate: true,
        });
    });


    function sendCode() {
        $.ajax({
            url:"send-code",
            async:false,
            method:'post',
            success:function(res){
                console.log(res);
            }});
    }
</script>
