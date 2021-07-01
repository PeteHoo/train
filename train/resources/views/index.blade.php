<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>


        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }
            .top-left {
                position: absolute;
                left: 50px;
                top: 38px;
            }

            .large-left{
                position: absolute;
                left: 50px;
                top: 238px;
            }

            .top-right {
                position: absolute;
                right: 200px;
                top: 100px;
            }

            .content {
                text-align: center;
            }

            .large-content{
                padding-left: 800px;
                text-align: center;
            }

            .title {
                font-size: 42px;
            }
            .large-title {
                font-size: 80px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            /*.m-b-md {*/
                /*margin-bottom: 30px;*/
            /*}*/
            .logo{
                height: 60px;
                width: 60px;
            }
            .large-logo{
                height: 460px;
                width: 360px;
            }
        </style>
    </head>
@if(config('app.name')=='共乐学堂')
<div id="home_index" border='0' style="background:url({{config('app.cdn_url')}}/image/home.png) no-repeat;background-size:100%,100%; ">
                    <div class="top-right links">

                        <a href="auth/login"><img src="{{config('app.cdn_url')}}/image/login.png"></a>

                        <a href="/admin/phone-register"><img src="{{config('app.cdn_url')}}/image/register.png"></a>

                    </div>
</div>
    @elseif(config('app.name')=='食安员培训')
    <div id="home_index" border='0' style="background:url({{config('app.cdn_url')}}/image/homepage.jpg) no-repeat;background-size:100%,100%; ">
        <div class="top-right links">

            <a href="auth/login"><img src="{{config('app.cdn_url')}}/image/login.png"></a>

{{--            <a href="/admin/phone-register"><img src="{{config('app.cdn_url')}}/image/register.png"></a>--}}

        </div>
    </div>
@endif
<script>
    $('#home_index').css('height', window.innerHeight);
    $('#home_index').css('width', window.innerWidth);
</script>
    </body>
</html>
