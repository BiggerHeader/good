<?php
/**
 * Created by PhpStorm.
 * User: 140439
 * Date: 2018/3/29
 * Time: 11:15
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;

class AlipayController extends Controller
{
    public function alipayshow()
    {
        $alipay = app('alipay.web');
        $alipay->setOutTradeNo('order_id');
        $alipay->setTotalFee('order_price');
        $alipay->setSubject('goods_name');
        $alipay->setBody('goods_description');

        $alipay->setQrPayMode('4'); //该设置为可选，添加该参数设置，支持二维码支付。

        // 跳转到支付页面。
        return redirect()->to($alipay->getPayLink());
    }
}