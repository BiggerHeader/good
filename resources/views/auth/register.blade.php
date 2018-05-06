@extends('common.home.auth')

@section('style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css"
          rel="stylesheet">
@endsection

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">

                @if (session()->has('status'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{ session('status') }}
                    </div>
                @endif

                <section class="sign-area panel p-40">
                    <h3 class="sign-title">注册
                        <small>Or <a href="{{ route('login') }}" class="color-green">登录</a></small>
                    </h3>
                    <div class="row row-rl-0">
                        <div class="col-sm-6 col-md-7 col-left">
                            <form class="p-40" id="register_form" method="post" action="{{ route('register') }}">

                                {{ csrf_field() }}

                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="sr-only">用户名</label>
                                    <input type="text" class="form-control input-lg" placeholder="用户名" name="name"
                                           value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">学校</label>
                                    <select type="text" class="js-data-example-ajax form-control input-lg"
                                            placeholder="选择学校" id="schoole" name="schoole">
                                    </select>
                                </div>
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="sr-only">邮箱</label>
                                    <input type="email" class="form-control input-lg" placeholder="邮箱" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </div>
                                <div class="form-group custom-radio {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="sr-only">性别</label>
                                    <div style="display: inline-block">
                                        <input type="radio" class="" id="sex_man" name="sex" value="1" checked>
                                        <label class="color-mid" for="sex_man">
                                            男
                                        </label>
                                    </div>
                                    <div style="display: inline-block; padding-left: 30px;">
                                        <input type="radio" id="sex_human" value="0" name="sex">
                                        <label class="color-mid" for="sex_human">
                                            女
                                        </label>
                                    </div>

                                </div>


                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="sr-only">密码</label>
                                    <input type="password" class="form-control input-lg" placeholder="密码"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">确认密码</label>
                                    <input type="password" class="form-control input-lg" placeholder="确认密码"
                                           name="password_confirmation" required>
                                </div>

                                <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                    <label class="sr-only">验证码</label>

                                    <div style="position: relative;">
                                        <input width="50px" id="text" maxlength="4" type="text"
                                               class="form-control input-lg" name="captcha" placeholder="验证码" required>
                                        <img style="position: absolute;top: 0; right: 0; cursor: pointer;"
                                             src="{{captcha_src()}}"
                                             onclick="this.src='{{ url("captcha/default") }}?'+Math.random()" alt="验证码"
                                             id="captcha">
                                    </div>


                                    @if ($errors->has('captcha'))
                                        <div class="has-error">
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('captcha') }}</strong>
                                                </span>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-block btn-lg">注 册</button>
                            </form>
                            <span class="or">Or</span>
                        </div>
                        <div class="col-sm-6 col-md-5 col-right">
                            <div class="social-login p-40">
                                <div class="mb-20">
                                    <img src="{{asset("images/Scnu_logo.png")}}">
                                </div>

                                <div class="text-center color-mid">
                                    已经有账号 ? <a href="{{ route('login') }}" class="color-green">登录</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </main>
@endsection


@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
    <script>
        $(function () {
            //远程筛选
            $(".js-data-example-ajax").select2({
                minimumInputLength: 2,
                placeholder: '输入你的大学名',
                language: {
                    inputTooShort: function () {
                        return "必须输入大于2个字符";
                    }
                },
                ajax: {
                    url: 'http://yaf.dtcode.cn/schoole/schoole/get',
                    dataType: 'json',
                    delay: 30,
                    data: function (params) {
                        return {
                            name: params.term, // search term
                        };
                    },
                    processResults: function (data, params) {
                        //  params.page = params.page || 1;
                        console.log(data.data, params);
                        data = data.data;
                        return {
                            results: data.map(function (d) {
                                return {
                                    id: d.id,
                                    text: d.name
                                }
                            }),
                        };
                    }
                },
            });
        });


    /*    $('#register_form').submit(function () {

            if (!$('#agree_terms').is(':checked')) {
                $('#checkbox_text').text('请同意MondayShop隐私声明');

                setTimeout(function () {
                    $('#checkbox_text').text('');
                }, 3000);

                return false;
            }

            return true;
        });*/
    </script>
@endsection