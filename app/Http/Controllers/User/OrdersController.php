<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Repositories\AddressRepository;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Webpatser\Uuid\Uuid;

class OrdersController extends Controller
{
    /*
     * 保存 选择地址
     * */
    public function setOrderAddress(Request $request)
    {
        $this->validate($request, ['address_id.required' => '请选地址', 'id.required' => '订单ID为空']);
        $update_res = Order::where('id', $request->input('id'))->update(['address_id' => $request->input('address_id')]);
        if ($update_res) {
            //跳转到支付页面
            return redirect()->route('pay_page', ['order_id' => $request->input('id')]);
        } else {
            echo 'error';
        }
    }

    /*
     * 获取选择地址
     * */
    public function getChooseAddress($order_id)
    {
        if (!empty($order_id)) {
            $addresses = AddressRepository::getAddreses();
            $data = Order::where('id', $order_id)->select('total_money', 'id')->first()->toArray();
            //地址参数
            return view('user.orders.choose_addr', compact('addresses', 'data'));
        }
    }

    public function index()
    {
        $orders = Auth::user()->orders;
        return view('user.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        //$request->all()  获取 所有请求参数
        $this->validate($request, ['productid_number.required' => '请选择商品']);

        // cars to orders
        $productid_number = $request->post('productid_number');

        DB::beginTransaction();
        $order_data = [];
        //  需要修改 ？？？？？ 不能相信客户端数据
        //获取所有 商品数据
        $product_data = Product::whereIn('id', array_keys($productid_number))->get();
        $order_data['total_money'] = $this->getTotal($product_data, $productid_number);
        $order_data['user_id'] = $request->user()->id;
        $order_data['uuid'] = $this->generateUuid();
        $order_data['status'] = 0;
        $order_data['created_at'] = date('Y-m-d H:i:s');
        $order_data['updated_at'] = date('Y-m-d H:i:s');
        //var_dump($order_data);exit();
        $res = Order::create($order_data);
        //创建订单
        if (!$res) {
            DB::rollBack();
            return back()->with('status', '服务器异常，请稍后再试');
        }
        //组装  订单详情数据
        $order_detail_data = [];
        $user_id = Auth::guard()->user();
        foreach ($productid_number as $key => $item) {
            $order_detail_data[] = [
                'order_id' => $res->id,
                'product_id' => $key,
                'numbers' => $item,
                'user_id' =>$user_id ,
            ];
            Product::where('id', $key)->increment(['safe_count' => $item]);
        }
        //提交数据
        if (!OrderDetail::insert($order_detail_data)) {
            DB::rollBack();
            return back()->with('status', '服务器异常，请稍后再试');
        }

        // delete cars data
        $request->user()->cars()->delete();
        DB::commit();
        return redirect()->route('choose_address', ['order_id' => $res->id]);
    }


    protected function single(Request $request)
    {

        if ($this->isGreaterStock($request->all())) {
            return [
                'code' => 302,
                'msg' => '购买的数量大于库存量'
            ];
        }

        // cars to orders
        $order_data = $this->formatSingleData($request);

        $order = $request->user()->orders()->create($order_data);

        $detail_data = [
            'numbers' => $request->input('numbers'),
            'product_id' => $request->input('product_id'),
            'order_id' => $order->id,
        ];
        OrderDetail::create($detail_data);


        // Reduce inventory
        ProductDetail::where('product_id', $detail_data['product_id'])
            ->lockForUpdate()
            ->first()
            ->decrement('count', $detail_data['numbers']);

        return [
            'code' => 0,
            'msg' => '购买成功'
        ];
    }

    /**
     * check buy number is greater stock numbers
     * @param array $data
     * @return array
     */
    protected function isGreaterStock(array $data)
    {
        // buy numbers > count
        $product = Product::find($data['product_id']);

        if ($data['numbers'] > $product->productDetail->count) {
            return true;
        }

        return false;
    }

    public function show(Order $order)
    {
        if ($order->user_id != Auth::user()->id) {
            abort(404, '你没有权限');
        }
        // dd($order->address->name);
        return view('user.orders.show', compact('order'));
    }

    private function generateUuid()
    {
        //$address_id = $request->input('address_id');
        //generate  order  id
        return Uuid::generate()->hex;
    }

    private function getTotal($product_data, $productid_number)
    {
        $total = 0;

        foreach ($product_data as $product_datum) {
            $total += $productid_number[$product_datum->id] * $product_datum->price;
        }

        return $total;
    }

    private function formatSingleData($request)
    {
        $product_id = $request->input('product_id');
        $numbers = $request->input('numbers');
        $address_id = $request->input('address_id');
        $uuid = Uuid::generate()->hex;
        $total = Product::find($product_id)->price * $numbers;

        return compact('product_id', 'total', 'uuid', 'address_id');
    }
}
