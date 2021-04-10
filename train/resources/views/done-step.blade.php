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

    .my-regster-page{
        align-items: center;
        background: #ededed;
        display: flex;
        flex-direction: column;
        height: 50vh;
        justify-content: center;
    }
</style>

<div class="my-regster-page bg-40">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body shadow-100">
                <p class="login-box-msg mt-1 mb-1">审核</p>

                <form id="login-form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <span>{{$description}}</span>
                    <span onclick="backLogin()" class="btn btn-primary float-right">

                        {{ __('admin.goto_login') }}
                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </span>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function backLogin() {
        window.location.href='/admin/auth/login';
    }
</script>
