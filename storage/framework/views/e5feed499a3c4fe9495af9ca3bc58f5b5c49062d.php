<!doctype html>
<html lang="en">
<head>
    <?php echo $__env->make('common.admin.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <title><?php echo $__env->yieldContent('title', 'Shop'); ?></title>

    <?php echo $__env->yieldContent('style'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/admin/lib/jquery/1.9.1/jquery.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/bootstrap.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/layui.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/admin/lib/layer/2.4/layer.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/layui.css')); ?>"  media="all">

</head>
<body class="easyui-layout social-container double-time-container">
<div id="dialog" style="padding:0px;"></div>
<div id="ajax-mask" style="display: none">
    <div class="ajax-mask"></div>
    <img class="ajax-loading" src="<?php echo e(asset('images/ajax-loading.gif')); ?> "></div>

<?php echo $__env->yieldContent('main'); ?>

<?php echo $__env->make('common.admin.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldContent('script'); ?>
</body>
</html>




