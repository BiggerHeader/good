<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\ApiController;
use App\Jobs\CreatePayment;
use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

class PaymentsController extends ApiController
{
    public function index($order_id)
    {
        $data = Order::where('id', $order_id)->select('total_money', 'id', 'uuid', 'change_money')->first()->toArray();
        return view('user.payments.index', compact('data'));
    }

    public function pay(Request $request)
    {

        if (($validator = $this->validatePayParam($request->all()))->fails()) {
            return $this->setCode(303)->setMsg($validator->errors()->first());
        }
        $pay_data = $this->getFormData($request->only(['price', 'istype', 'orderuid']));

        CreatePayment::dispatch($pay_data);

        return $this->setMsg('生成支付信息成功')->setData($pay_data)->toJson();
    }

    public function paynotify(Request $request)
    {

        $pay_data = $request->only(['paysapi_id', 'orderid', 'price', 'realprice', 'orderuid']);
        $pay_data['token'] = config('payment.token');

        ksort($pay_data);
        $temps = md5(implode('', $pay_data));
        $Key = $request->input('key');


        if (md5($temps) != $Key) {
            file_put_contents('pay.log', "校验出错 \r\n", FILE_APPEND);
            return $this->setCode(303)->setMsg('校验出错')->toJson();
        }

        $payment = Payment::where('orderid', $pay_data['orderid'])->first();

        if (!$payment) {
            file_put_contents('pay.log', "不存在此次支付 \r\n", FILE_APPEND);
            return $this->setCode(305)->setMsg('不存在此次支付')->toJson();
        }

        $payment->paysapi_id = $pay_data['paysapi_id'];
        $payment->status = 1;
        $payment->save();

        file_put_contents('pay.log', "{$payment->paysapi_id} \r\n", FILE_APPEND);

        return $this->setMsg('SUCCESS');
    }

    public function payreturn(Request $request)
    {
        // TODO The query model causes an infinite refresh of the payment callback jump
        dd($request->all());

        $payment = Payment::where('orderid', $request->input('orderid'))->first();

        dd($request->all());

        return view('user.payments.result', compact('payment'));
    }

    private function validatePayParam(array $data)
    {
        return Validator::make($data, [
            'price' => 'required|numeric',
            'istype' => 'in:1,2',
            'orderuid' => 'required|string',
            //'goodsname' => 'required|exists:products,name'
        ]);
    }

    private function getFormData(array $data)
    {
        $sys_data = [
            'uid' => config('payment.uid'),
            'token' => config('payment.token'),
            'notify_url' => config('payment.notify_url'),
            'return_url' => config('payment.return_url'),
            'orderid' => $data['orderuid'],
        ];

       /* if (mb_strlen($data['goodsname'], 'utf8') > 8) {
            $data['goodsname'] = mb_substr($data['goodsname'], 0, 8, 'utf8');
        }*/

        $data = array_merge($sys_data, $data);
        ksort($data);
        $data['key'] = md5(implode('', $data));

        unset($data['token']);

        return $data;
    }
}
