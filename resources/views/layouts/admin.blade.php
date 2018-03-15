<!doctype html>
<html lang="en">
<head>
    @include('common.admin.meta')

    <title>@yield('title', 'Shop')</title>
    @yield('style')
</head>
<body class="easyui-layout social-container double-time-container">
<div id="dialog" style="padding:0px;"></div>
<div id="ajax-mask" style="display: none"><div class="ajax-mask"></div><img class="ajax-loading" src="{{asset('/bootstrap/images/ajax-loading.gif')}} "></div>

    @yield('main')

    @include('common.admin.js')
    @yield('script')
</body>
</html>




