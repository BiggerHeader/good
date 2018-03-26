@extends('layouts.home')

@section('main')

    <div class="container">
        <h3 class="h-title mb-30">意见反馈</h3>
        <form class="form-horizontal">
            @if(auth()->user())
                <div class="form-group">
                    <label for="exampleInputName2">姓名</label>
                    <input type="text" class="form-control" id="exampleInputName2"
                           placeholder="Jane Doe" value="{{auth()->user()->name}}">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail2">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com"
                           value="{{auth()->user()->email}}">
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="content"></textarea>
                </div>
            @else
                <div class="form-group">
                    <label for="exampleInputName2">姓名</label>
                    <input type="text" class="form-control" id="exampleInputName2"
                           placeholder="Jane Doe">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail2">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="content"></textarea>
                </div>
            @endif
            <div class="form-group">
                <button type="button" name="tijao" id="tijao" class="btn btn-primary">提交</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script>
        var url = "http://yaf.com/feedback/feedback/add";
        $('#tijao').click(function () {
            var name = $('#exampleInputName2').val(), email = $('#exampleInputEmail2').val(),
                content = $("textarea[name=content]").val();
            var data = JSON.stringify({
                name: name,
                email: email,
                content: content
            })
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                dataType: "json",
                success: function (respones) {
                    if (respones.code == 10000) {
                        layer.msg(respones.msg);
                        window.location.href='{{url('/')}}'
                    } else {
                        layer.msg(respones.msg);
                    }
                }
            })
        });
    </script>
@endsection