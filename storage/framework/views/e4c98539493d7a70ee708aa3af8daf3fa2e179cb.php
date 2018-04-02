

<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
  <div class="pd-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
      <thead>
      <tr class="text-c">
        <th width="100">用户名</th>
        <th width="40">头像</th>
        <th width="150">邮箱</th>
        <th width="130">加入时间</th>
        <th width="70">状态</th>
        <th width="100">操作</th>
      </tr>
      </thead>
      <tbody>
        <?php $userPresenter = app('App\Presenters\UserPresenter'); ?>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr class="text-c">
            <td>
              <u style="cursor:pointer" class="text-primary">
                <?php echo e($user->name); ?>

              </u>
            </td>
            <td><img src="<?php echo e($userPresenter->getAvatarLink($user->avatar)); ?>" style="width: 40px;height: 40px;"></td>
            <td><?php echo e($user->email); ?></td>
            <td><?php echo e($user->created_at); ?></td>
            <td class="user-status">
              <?php echo $userPresenter->getStatusSpan($user->is_active); ?>

            </td>
            <td class="f-14 user-manage">
              <a style="text-decoration:none" onClick="user_stop(this,'10001')" href="javascript:;" title="停用"><i class="icon-hand-down"></i></a>
              <a title="编辑" href="javascript:;" onclick="user_edit('4','550','','编辑','user-add.html')" class="ml-5" style="text-decoration:none"><i class="icon-edit"></i></a>
              <a style="text-decoration:none" class="ml-5" onClick="user_password_edit('10001','370','228','修改密码','user-password-edit.html')" href="javascript:;" title="修改密码"><i class="icon-key"></i></a>
              <a title="删除" href="javascript:;" onclick="user_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="icon-trash"></i></a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
    <div id="pageNav" class="pageNav">
        <?php echo e($users->links()); ?>

    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>