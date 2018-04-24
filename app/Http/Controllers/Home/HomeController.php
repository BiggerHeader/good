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
        $category = DB::select('select count,id,name  from categories  c left join 
  (SELECT  count(*) as count,category_id  FROM  products GROUP  BY category_id )p 
on p.category_id = c.id
  order by  parent_id desc  limit 9 ');
        $categories = array_map(function ($item) {
            return (array)$item;
        }, $category);
        $hotProducts = DB::select('select count,name,id,price,thumb,title,price_original 
from products a LEFT JOIN  (SELECT  count(*) as count,product_id  
FROM  likes_products  GROUP BY product_id )b  
on a.id=b.product_id where a.is_alive=1 order  by  safe_count desc limit 9  ');
        $hotProducts = array_map(function ($item) {
            return (array)$item;
        }, $hotProducts);

        $latestProducts = DB::select('select count,name,id,price,thumb,title,price_original 
from products a LEFT JOIN  (SELECT  count(*) as count,product_id  
FROM  likes_products  GROUP BY product_id )b  
on a.id=b.product_id where a.is_alive=1 order  by  created_at desc limit 9 ');
        $latestProducts = array_map(function ($item) {
            return (array)$item;
        }, $latestProducts);

        $users = DB::select("select name,avatar from users   order  by  login_count desc limit 10");
        $users = array_map(function ($item) {
            return (array)$item;
        }, $users);

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
