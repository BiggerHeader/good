

<?php $__env->startSection('main'); ?>
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
                            <div class="cart-price">
                                <h3 class="h-title mb-30 t-uppercase">我的购物车</h3>
                                
                                <form class="mb-30" method="post" action="<?php echo e(url('/user/orders/')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <table id="cart_list" class="cart-list mb-30">
                                        <thead class="panel t-uppercase">
                                        <tr>
                                            <th>商品名字</th>
                                            <th>单价</th>
                                            <th>数量</th>
                                            <th>金额</th>
                                            <th>删除</th>
                                        </tr>
                                        </thead>
                                        <tbody id="cars_data">
                                        <?php $productPresenter = app('App\Presenters\ProductPresenter'); ?>
                                        <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="panel alert">
                                                <td>
                                                    <div class="media-body valign-middle">
                                                        <h6 class="title mb-15 t-uppercase">
                                                            <input type="checkbox" name="product_id[]"
                                                                   value="<?php echo e($car->product->id); ?>">
                                                            <a href="<?php echo e(url("/home/products/{$car->product->id}")); ?>">
                                                                <?php echo e($car->product->name); ?>

                                                            </a>
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td class="prices"><?php echo e($car->product->price); ?></td>
                                                <td>
                                                    <button type="button" class="reduce">-</button>
                                                    <input class="quantity-label count" type="number" name="productid_number[<?php echo e($car->product->id); ?>]"
                                                           value="<?php echo e($car->numbers); ?>" style="width: 20px" readonly>
                                                    <button type="button" class="add">+</button>
                                                </td>
                                                <td>
                                                    <label style="color:red;">¥<input
                                                                class="quantity-label single_total" type="number"
                                                                value="<?php echo e($car->numbers * $car->product->price); ?>"></label>
                                                </td>
                                                <td>
                                                    <button data-id="<?php echo e($car->id); ?>" class="close delete_car"
                                                            type="button">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <div class="t-right">
                                        <!-- Checkout Area -->
                                        <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                            <h2 class="h3 mb-20 h-title">订单信息</h2>
                                            


                                            

                                            <div class="row">
                                                <div class="checkbox pull-left">
                                                    <label>
                                                        <input type="checkbox" value="">
                                                        全选
                                                    </label>
                                                </div>
                                                <span>已选择商品
                                                    <span class="cars_count">0</span>
                                                    件
                                                </span>
                                                <span>
                                                    合计
                                                    <span class="cars_price">0</span>
                                                    ￥
                                                </span>
                                                <?php if(auth()->guard()->check()): ?>
                                                <button type="submit" class="btn btn-lg btn-rounded mr-10">下单</button>
                                                <?php endif; ?>
                                                <?php if(auth()->guard()->guest()): ?>
                                                <a href="<?php echo e(url('login')); ?>?redirect_url=<?php echo e(url()->current()); ?>"
                                                   class="btn btn-lg btn-rounded mr-10">下单</a>
                                                <?php endif; ?>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/user/layer/2.4/layer.js')); ?>"></script>
    <script>
        var token = '<?php echo e(csrf_token()); ?>';
        var cars_url = "<?php echo e(url("/home/cars")); ?>/";
        $('.delete_car').click(function () {
            var that = $(this);
            var id = that.data('id');
            var _url = cars_url + id;
            $.post(_url, {_token: token, _method: 'DELETE'}, function (res) {
                if (res.code == 302) {
                    localStorage.removeItem(id);
                }
                that.parent().parent().remove();
                getTotal();
            });
        });

        function getTotal() {
            var total = 0;
            var checkBox = $('#cars_data .panel input:checked');
            $('.cars_count').text(checkBox.length);
            checkBox.each(function () {
                var panel = $(this).parents('.panel');
                var price = panel.find('.prices').text();
                var numbers = panel.find('.count').val();
                total += price * numbers;
            });
            $('.cars_price').text(total);
        }
    </script>

    <script>
        var reduce = $('.reduce');
        var add = $('.add');
        add.on('click', function () {
            var parent = $(this).parents('.panel');
            var value = parent.find('.count');
            var prices = parent.find('.prices').text();
            var singleTotal = parent.find('.single_total');
            value.val(value.val() * 1 + 1);
            singleTotal.val(value.val() * prices);
            getTotal();
        })
        reduce.on('click', function () {
            var parent = $(this).parents('.panel');
            var value = parent.find('.count');
            var prices = parent.find('.prices').text();
            var singleTotal = parent.find('.single_total');
            if (value.val() <= 1) {
                value.val(1);
            } else {
                value.val(value.val() * 1 - 1);
            }
            singleTotal.val(value.val() * prices);
            getTotal();
        })
        $('#cars_data .panel input[type="checkbox"]').on('change', function () {
            if ($('#cars_data .panel input[type="checkbox"]').length === $('#cars_data .panel input:checked').length) {
                $('.pull-left input').prop('checked', true);
            } else {
                $('.pull-left input').prop('checked', false);
            }
            getTotal();
        })
        $('.pull-left input').on('change', function() {
            var value = $(this).prop('checked');
            $('#cars_data .panel input[type="checkbox"]').prop('checked', value);
            getTotal();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>