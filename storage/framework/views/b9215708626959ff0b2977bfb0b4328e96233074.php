<!-- Header Header -->
<div class="header-header bg-white">
    <div class="container">
        <div class="row row-rl-0 row-tb-20 row-md-cell">
            <div class="brand col-md-3 t-xs-center t-md-left valign-middle">
                <a href="<?php echo e(url('/')); ?>" class="logo">
                    <img src="<?php echo e(asset('assets/shop/images/logo.png')); ?>" alt="" style="height: 90px;width: 180px;">
                </a>
            </div>
            <div class="header-search col-md-9">
                <div class="row row-tb-10 ">
                    <div class="col-sm-8">
                        <form class="search-form" method="get" action="<?php echo e(url('/home/products/search')); ?>">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control input-lg search-input"
                                       placeholder="输入关键字 ..." required="required">
                                <div class="input-group-btn">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-lg btn-search btn-block">
                                                <i class="fa fa-search font-16"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4 t-xs-center t-md-right">
                        <div class="header-cart">
                            <a href="<?php echo e(url('/home/cars')); ?>">
                                <span id="car_icon" class="icon lnr lnr-cart"></span>
                                <div>
                                    <span id="cart-number" class="cart-number">0</span>
                                </div>
                                <span class="title" id="car_title">购物车</span>
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Header Header -->

<script>
    var car_nums_span = document.getElementById('cart-number');
    <?php if(auth()->guard()->check()): ?>
        car_nums_span.innerText = parseInt("<?php echo e(Auth::user()->cars->count()); ?>");
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    localStorage.clear();
    <?php endif; ?>
</script>
