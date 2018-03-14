<?php
/**
 * Created by PhpStorm.
 * User: 140439
 * Date: 2018/3/13
 * Time: 16:09
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;


/**
 * Class OrdersController
 * @package App\Http\Controllers\Admin
 */
class OrdersController extends Controller
{


    /** 后台显示订单列表
     * @param $where
     */
    public function orders($status = null, $orderid = null)
    {
        $status = intval($status);
        $where = [];
        if (!empty($orderid)) {
            $where['uuid'] = $orderid;
        }
        if (isset($status) && $status >= 0) {
            $where['status'] = $status;
        }
        $orders = Order::where($where)->get();
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
            echo json_encode($orders->toArray());
        } else {
            return view('admin.orders.list', compact('orders'));
        }
    }

    /**
     *修改 order 状态
     */
    public function modify(Request $request)
    {
        $this->validate($request, ['uuid.required' => '参数有误', 'status.required' => '参数有误']);
        $status = intval($request->input('status'));
        if ($status == 1) {
            $msg = '取消发货';
        } else {
            $msg = '发货';
        }
        $update_res = Order::where('uuid', $request->input('uuid'))->update(['status' => $status]);
        if ($update_res) {
            echo json_encode(['status' => $status, 'msg' => $msg, 'code' => 200]);
        } else {
            echo json_encode(['status' => 'errror', 'msg' => $msg, 'code' => 999]);

        }
        exit();
    }
}