<?php
/*mail   test */
Route::get('sendmail', function (Illuminate\Http\Request $request) {
    //Mail::to('1343652445@qq.com')->send(new \App\Mail\UserRegister($request->user()));

});
Route::get('/queue', 'Test\TqueueController@index');


/**********  auth  **********/
Auth::routes();

Route::namespace('Auth')->group(function () {
    // account active link
    Route::get('/register/active/{token}', 'UserController@activeAccount');
    // again send active link
    Route::get('/register/again/send/{id}', 'UserController@sendActiveMail');

    // github,qq,weibo authorize login
    Route::get('/auth/github', 'AuthLoginController@redirectToGithub');
    Route::get('/auth/github/callback', 'AuthLoginController@handleGithubCallback');
    Route::get('/auth/qq', 'AuthLoginController@redirectToQQ');
    Route::get('/auth/qq/callback', 'AuthLoginController@handleQQCallback');
    Route::get('/auth/weibo', 'AuthLoginController@redirectToWeibo');
    Route::get('/auth/weibo/callback', 'AuthLoginController@handleWeiboCallback');
});

/**********  home  **********/
Route::get('/', 'Home\HomeController@index');

Route::prefix('home')->namespace('Home')->group(function () {
    Route::get('/', 'HomeController@index');

    Route::get('/products/pinyin/{pinyin}', 'ProductsController@getProductsByPinyin');
    Route::get('/products/search', 'ProductsController@search');

    Route::resource('/categories', 'CategoriesController', ['only' => ['index', 'show']]);
    Route::resource('/products', 'ProductsController', ['only' => ['index', 'show']]);
    Route::resource('/cars', 'CarsController');
});

/**********  user  **********/
Route::middleware(['user.auth'])->prefix('user')->namespace('User')->group(function () {

    Route::get('/', 'UsersController@index');

    Route::post('/subscribe', 'UsersController@subscribe');
    Route::post('/desubscribe', 'UsersController@deSubscribe');

    // user password setting
    Route::get('/password', 'UsersController@showPasswordForm');
    Route::post('/password', 'UsersController@updatePassword');

    // user information setting
    Route::get('/setting', 'UsersController@setting');
    Route::post('/upload/avatar', 'UsersController@uploadAvatar');
    Route::put('/update', 'UsersController@update');

    // user address  default setting
    Route::post('/addresses/default/{address}', 'AddressesController@setDefaultAddress');
    //user  add address rollback
    Route::get('/addresses/region/{pid}', 'AddressesController@getRegion');
    Route::resource('/addresses', 'AddressesController');

    // user products like, cancel like,
    Route::get('/likes', 'LikesController@index');
    Route::match(['post', 'delete'], '/likes/{id}', 'LikesController@toggle');

    // user order show and index
    Route::post('/orders/single', 'OrdersController@single');
    Route::resource('/orders', 'OrdersController', ['only' => ['index', 'store', 'show']]);
    //user choose address  if not else redirect
    Route::get('/choose/address/{order_id}', 'OrdersController@getChooseAddress')->name('choose_address');
    Route::post('/submit/address', 'OrdersController@setOrderAddress');
    // user payments
    Route::get('/pay/show/{order_id}', 'PaymentsController@index')->name('pay_page');
    Route::post('/pay/store', 'PaymentsController@pay');
});
// user payments !!! If [user.auth] is validated, infinite jumps will occur
Route::get('/user/pay/return', 'User\PaymentsController@payreturn');
Route::post('/user/pay/notify', 'User\PaymentsController@paynotify');


/**********  admin  **********/
Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login');
Route::post('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');


//prefix 键定义 URI 的公共部分，namespace 键定义方法名（命名空间语法）的公共部分
Route::middleware(['admin.auth', 'admin.permission'])->prefix('admin')->namespace('Admin')->group(function () {

    // admin home page
    Route::get('/', 'HomeController@index');
    Route::get('/welcome', 'HomeController@welcome')->name('admin.welcome');

    // change product Alive or undercarriage
    Route::any('/products/change/alive/{product}', 'ProductsController@changeAlive');
    // product image and product list image upload
    Route::post('/products/upload/images', 'ProductsController@upload');
    Route::post('/products/upload/detail', 'ProductsController@uploadDetailImage');
    Route::post('/products/delete/images', 'ProductsController@deleteImage');


    Route::resource('/categories', 'CategoriesController');
    Route::resource('/products', 'ProductsController');
    Route::resource('/comments', 'CommentsController');

    /*后台显示  订单*/
    Route::get('/orders/{status}/{orderid?}', 'OrdersController@orders');
    Route::post('/order/modify', 'OrdersController@modify');

    Route::get('/test', 'OrdersController@test');

    Route::resource('/productImages', 'ProductImagesController', ['only' => ['index', 'destroy']]);
    Route::resource('/users', 'UsersController', ['only' => ['index']]);
    Route::resource('/admins', 'AdminsController');
    Route::resource('/roles', 'RolesController');
});