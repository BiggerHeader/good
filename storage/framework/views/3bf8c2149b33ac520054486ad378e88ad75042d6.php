

<?php $__env->startSection('main'); ?>
    <main id="mainContent" class="main-content">
        <!-- Page Container -->
        <div class="page-container ptb-60">
            <div class="container">
                <section class="stores-area stores-area-v1">
                    <h3 class="mb-40 t-uppercase">查看所有分类</h3>
                    <div class="row row-rl-15 row-tb-15 t-center">

                        <?php $categoryPresenter = app('App\Presenters\CategoryPresenter'); ?>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                <a href="<?php echo e(url("/home/categories/{$category->id}")); ?>" class="panel is-block">
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <div class="store-logo">
                                            <img src="<?php echo e($categoryPresenter->getThumbLink($category->thumb)); ?>" alt="<?php echo e($category->name); ?>">
                                        </div>
                                    </div>
                                    <h6 class="store-name ptb-10"><?php echo e($category->name); ?></h6>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                    <div class="page-pagination text-center mt-30 p-10 panel">
                        <nav>
                            <!-- Page Pagination -->
                            <?php echo e($categories->links()); ?>

                            <!-- End Page Pagination -->
                        </nav>
                    </div>
                </section>
            </div>
        </div>
        <!-- End Page Container -->


    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>