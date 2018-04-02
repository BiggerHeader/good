


<?php $__env->startSection('main'); ?>
    <div class="page-container">
        <?php if(session()->has('status')): ?>
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i><?php echo e(session('status')); ?></div>
        <?php endif; ?>


        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">管理员列表</th>
            </tr>
            <tr class="text-c">
                <th width="150">登录名</th>
                <th>角色</th>
                <th width="130">加入时间</th>
                <th width="100">上一次登录ip</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="text-c">
                    <td><?php echo e($admin->name); ?></td>
                    <td><?php echo implode('&nbsp;&nbsp;', $admin->getRoleNames()->toArray()); ?></td>
                    <td><?php echo e($admin->created_at); ?></td>
                    <td><?php echo e(dump($admin->last_ip)); ?></td>
                    <td class="td-manage">
                        <a title="编辑" href="<?php echo e(url('admin/admins/'.  $admin->id .'/edit')); ?>"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" data-id="<?php echo e($admin->id); ?>" class="ml-5 delete_admin" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <form id="delete_form" action="" method="post">
            <?php echo e(csrf_field()); ?>

            <?php echo e(method_field('DELETE')); ?>

        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $('.delete_admin').click(function () {
            var id = $(this).data('id');
            var uri = "<?php echo e(url('/admin/admins')); ?>/" + id;

            $('#delete_form').attr('action', uri);
            $('#delete_form').submit();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>