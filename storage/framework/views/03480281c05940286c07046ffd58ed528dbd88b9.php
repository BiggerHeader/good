

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(asset('assets/admin/static/h-ui.admin/css/H-ui.login.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
    <input type="hidden" id="TenantId" name="TenantId" value="" />
    <div class="header"></div>
    <div class="loginWraper">
        <div id="loginform" class="loginBox">

            <?php if(session()->has('status')): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <form class="form form-horizontal" action="<?php echo e(url('admin/login')); ?>" method="post">
                <?php echo e(csrf_field()); ?>


                <div class="row cl <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                    <div class="formControls col-xs-8">
                        <input id="" name="name" type="text" placeholder="账号" class="input-text size-L" value="<?php echo e(old('name')); ?>">
                        <?php if($errors->has('name')): ?>
                            <span class="help-block">
                                <strong><?php echo $errors->first('name'); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row cl <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                    <div class="formControls col-xs-8">
                        <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">

                        <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row cl <?php echo e($errors->has('captcha') ? ' has-error' : ''); ?>">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe725;</i></label>
                    <div class="formControls col-xs-8">
                        <div style="position: relative;">
                            <input name="captcha" type="text" placeholder="验证码" class="input-text size-L">
                            <img style="position: absolute;top: 0; right: 42px; cursor: pointer;height: 41px;" src="<?php echo e(captcha_src()); ?>" onclick="this.src='<?php echo e(url("captcha/default")); ?>?'+Math.random()" alt="验证码"  id="captcha">

                            <?php if($errors->has('captcha')): ?>
                                <span class="help-block">
                                <strong><?php echo $errors->first('captcha'); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="row cl">
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <input type="submit" class="btn btn-success radius size-L" style="width: 100%" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">

                    </div>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/admin/lib/jquery/1.9.1/jquery.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/admin/static/h-ui/js/H-ui.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>