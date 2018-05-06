@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('main')
  <div class="pd-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
      <thead>
      <tr class="text-c">
        <th width="100">用户名</th>
        <th width="40">头像</th>
        <th width="150">邮箱</th>
        <th width="130">加入时间</th>
        <th width="70">状态</th>
      </tr>
      </thead>
      <tbody>
        @inject('userPresenter', 'App\Presenters\UserPresenter')
        @foreach ($users as $user)
          <tr class="text-c">
            <td>
              <u style="cursor:pointer" class="text-primary">
                {{ $user->name }}
              </u>
            </td>
            <td><img src="{{asset("images/Scnu_logo.png")}}" style="width: 40px;height: 40px;"></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td class="user-status">
              {!! $userPresenter->getStatusSpan($user->is_active) !!}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div id="pageNav" class="pageNav">
        {{ $users->links() }}
    </div>
  </div>
@endsection