

<?php $__env->startSection('main'); ?>
	<div class="page-container">

        <?php if(session()->has('status')): ?>
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i><?php echo e(session('status')); ?></div>
        <?php endif; ?>

		<div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" id="batch_delete_btn" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
            </span>
            <span class="l" style="margin-left: 10px;">
                <a class="btn btn-success radius r"  href="javascript:location.reload();" title="刷新" >
                    <i class="Hui-iconfont">&#xe68f;</i>
                </a>
            </span>

            <span class="r">共有数据：<strong><?php echo e($categories->count()); ?></strong> 条</span>
        </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
					<th width="40"><input name="" type="checkbox" value=""></th>
					<!-- <th width="50">ID</th> -->
					<th width="100">分类名称</th>
					<th width="200">父级分类</th>
					<th width="100">创建时间</th>
					<th width="100">更新时间</th>
					<th width="100">操作</th>
				</tr>
				</thead>
				<tbody>
				    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr class="text-c">
							<td><input name="catetory_id" type="checkbox" value="<?php echo e($category->id); ?>"></td>
							<!-- <td><?php echo e($category->id); ?></td> -->
							<td class="text-l">
                                <?php echo $category->className; ?>

                            </td>
							<td class="text-l"><?php echo e($category->parentClass); ?></td>
							<td><?php echo e($category->created_at); ?></td>
							<td><?php echo e($category->updated_at); ?></td>
							<td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" href="<?php echo e(url('admin/categories/'.  $category->id .'/edit')); ?>" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>

                                <a href="javascript:;" class="ml-5 delete_category" data-id="<?php echo e($category->id); ?>" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                            </td>
						</tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <form id="delete_form" action="<?php echo e(url('admin/categories')); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('DELETE')); ?>


                    </form>
				</tbody>
			</table>
		</div>
	</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script>
        $('.delete_category').click(function(){
            var id = $(this).data('id');

            var url = $('#delete_form').attr('action') + '/' + id;

            $('#delete_form').attr('action', url);

            $('#delete_form').submit();
        });

        $('#batch_delete_btn').click(function(){
            $('input[name=catetory_id]:checked').each(function (index,element) {

                var url = $('#delete_form').attr('action') + '/' + $(this).val();

                $.post(url, {_token:'<?php echo e(csrf_token()); ?>', _method:'DELETE'}, function(res){
                    if (res.code == 0) {
                        layer.msg(res.msg + '  请刷新数据');
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>