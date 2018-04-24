@extends('layouts.admin')


@section('main')
    <div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif




        <form id="delete_form" action="" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('.delete_admin').click(function () {
            var id = $(this).data('id');
            var uri = "{{ url('/admin/admins') }}/" + id;

            $('#delete_form').attr('action', uri);
            $('#delete_form').submit();
        });
    </script>
@endsection