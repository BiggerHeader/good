<?php

namespace App\Http\Controllers\Home;

use App\Models\OrderDetail;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::inRandomOrder()->take(9)->get(['id', 'name'])->split(3);

        $productPinyins = Product::groupBy('first_pinyin')->get(['first_pinyin']);

        return view('home.products.index', compact('products', 'productPinyins'));
    }


    /**
     * ajax get products by pinyin first char
     * @param $pinyin
     * @return mixed
     */
    public function getProductsByPinyin($pinyin)
    {
        $products = Product::where('first_pinyin', $pinyin)->get(['id', 'name'])->split(3);

        return $products;
    }


    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $products = Product::where('name', 'like', "%{$keyword}%")->paginate(10);
        return view('home.products.search', compact('products'));
    }


    /**
     * 单页显示
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        $user = Auth::guard()->user();
        $recommendProducts = Product::where('category_id', $product->category_id)->take(5)->get();
        $is_buy = '';
        if (!empty($user)) {
            $is_buy = OrderDetail::where(['user_id' => $user->id, 'product_id' => $product->id])->count();
        }
        $comment_count = DB::table('comment')->where('product_id','=',$product->id)->count();

        return view('home.products.show', compact('product', 'recommendProducts', 'is_buy','comment_count'));
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
