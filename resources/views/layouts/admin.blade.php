<!doctype html>
<html lang="en">
<head>
    @include('common.admin.meta')

    <title>@yield('title', 'Shop')</title>

    @yield('style')
    <script type="text/javascript" src="{{ asset('assets/admin/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/layui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/lib/layer/2.4/layer.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/layui.css')}}"  media="all">

</head>
<body class="easyui-layout social-container double-time-container">
<div id="dialog" style="padding:0px;"></div>
<div id="ajax-mask" style="display: none">
    <div class="ajax-mask"></div>
    <img class="ajax-loading" src="{{asset('images/ajax-loading.gif')}} "></div>

@yield('main')

@include('common.admin.js')
@yield('script')
</body>
</html>




