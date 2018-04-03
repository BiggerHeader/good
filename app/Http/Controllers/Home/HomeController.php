<?php

namespace App\Http\Controllers\Home;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver;

class HomeController extends Controller
{
    public function index()
    {
        /*   $categories = Category::orderBy('parent_id', 'desc')->take(9)->get()->toArray();
           $hotProducts = Product::orderBy('safe_count', 'desc')->take(3)->get();
           $latestProducts = Product::latest()->take(9)->get();
           $users = User::orderBy('login_count', 'desc')->take(10)->get(['name', 'avatar']);
           var_dump($categories);exit();*/

        //修改这些从Redis 里面取
        $redis = new  \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('');
        $prefix = 'home:';
        $name = 'categories';

        //判断缓存的键是否还存在
        if (!$redis->exists($prefix . $name)) {
            //缓存不存在
            $data = DB::select('select count,id,name  from categories  c left join 
  (SELECT  count(*) as count,category_id  FROM  products GROUP  BY category_id )p 
on p.category_id = c.id
  order by  parent_id desc  limit 9 ');
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            //存入redis
            $redis->set($prefix . $name, $json);
            //设置过期时间 一天
            $redis->expire($prefix . $name, 60 * 60 * 24);
        }
        $name = 'hotPorducts';
        if (!$redis->exists($prefix . $name)) {
            //缓存不存在
            $data = Product::orderBy('safe_count', 'desc')->take(3)->get()->toArray();
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            //存入redis
            $redis->set($prefix . $name, $json);
            //设置过期时间 一天
            $redis->expire($prefix . $name, 60 * 60 * 24);
        }
        $name = 'latestProducts';
        if (!$redis->exists($prefix . $name)) {
            //缓存不存在
            $data = DB::select('select count,name,id,price,thumb,title,price_original from products a LEFT JOIN  (SELECT  count(*) as count,product_id  FROM  likes_products  GROUP BY product_id )b  on a.id=b.product_id order  by  created_at desc limit 9');
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            //存入redis
            $redis->set($prefix . $name, $json);
            //设置过期时间 一天
            $redis->expire($prefix . $name, 60 * 60 * 24);
        }

        $name = 'hotProducts';
        if (!$redis->exists($prefix . $name)) {
            //缓存不存在
            $data = DB::select("select name, from users a LEFT JOIN  (SELECT  count(*) as count,product_id  FROM  likes_products  GROUP BY product_id )b  on a.id=b.product_id order  by  safe_count desc limit 10");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            //存入redis
            $redis->set($prefix . $name, $json);
            //设置过期时间 一天
            $redis->expire($prefix . $name, 60 * 60 * 24);
        }


        $name = 'users';
        if (!$redis->exists($prefix . $name)) {
            //缓存不存在
            $data = DB::select("select name,avatar from users   order  by  login_count desc limit 10");
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            //存入redis
            $redis->set($prefix . $name, $json);
            //设置过期时间 一天
            $redis->expire($prefix . $name, 60 * 60 * 24);
        }

        $categories = $redis->get($prefix . 'categories');
        $hotProducts = $redis->get($prefix . 'hotProducts');
        $latestProducts = $redis->get($prefix . 'latestProducts');
        $users = $redis->get($prefix . 'users');

        $users = json_decode($users, JSON_UNESCAPED_UNICODE);

        $hotProducts = json_decode($hotProducts, JSON_UNESCAPED_UNICODE);
        $latestProducts = json_decode($latestProducts, JSON_UNESCAPED_UNICODE);
        $categories = json_decode($categories, JSON_UNESCAPED_UNICODE);

        return view('home.homes.index', compact('categories', 'hotProducts', 'latestProducts', 'users'));
    }

    /*
     * 意见反馈
     * */
    public function feedback()
    {
        return view('home.homes.feedback');
    }
}
