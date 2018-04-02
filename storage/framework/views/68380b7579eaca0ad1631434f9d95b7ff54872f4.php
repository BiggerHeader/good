


<?php $__env->startSection('main'); ?>

	<?php echo $__env->make('common.admin.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<?php echo $__env->make('common.admin.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<section class="Hui-article-box">
		<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
			<div class="Hui-tabNav-wp">
				<ul id="min_title_list" class="acrossTab cl">
					<li class="active">
						<span title="我的桌面" data-href="welcome.html">我的桌面</span>
						<em></em></li>
				</ul>
			</div>
			<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
		</div>
		<div id="iframe_box" class="Hui-article">
			<div class="show_iframe">
				<div style="display:none" class="loading"></div>

                <!-- <?php echo e(route('admin.welcome')); ?> -->
				<iframe scrolling="yes" frameborder="0" src="<?php echo e(url('admin/admins')); ?>"></iframe>
			</div>
		</div>
	</section>

	<?php echo $__env->make('common.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- 此处 footer 仅是 引入js -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>