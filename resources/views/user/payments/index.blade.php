<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0 ,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>结算页面</title>

    <link href="{{ asset('assets/user/AmazeUI-2.4.2/assets/css/amazeui.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/user/basic/css/demo.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/user/css/cartstyle.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/user/css/jsstyle.css') }}" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="{{ asset('js/payment.js') }}"></script>
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>

        .center {
            position: fixed;
            top: 50%;
            left: 50%;
            background-color: #000;
            width: 100px;
            height: 100px;
            -webkit-transform: translateX(-50%) translateY(-50%);
            -moz-transform: translateX(-50%) translateY(-50%);
            -ms-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
        }

        .div {
            width: 100%;
            position: absolute;
            top: 0;
            bottom: 0;


        }

        body {
            margin: 0;
            padding: 0;

        }
    </style>
</head>

<body>
<!--顶部导航条 -->
@include('common.user.header')
<!--支付方式-->
<div class="div">
    <a  style="display: block;" class="btn btn-primary btn-lg" href="{{asset('/home')}}" role="button">支付完成</a>
    <img src="{{ asset('images/shouqian.jpg') }}" style="width: 330px;height: 500px ;"  class="center"/>

</div>
<div class="clear"></div>


</body>

</html>