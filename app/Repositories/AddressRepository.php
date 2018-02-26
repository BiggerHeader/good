<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 2018/2/25
 * Time: 20:48
 */

namespace App\Repositories;


use DB;

class AddressRepository
{

    public static function getAddreses()
    {
        //获取一个用户 所有 地址
        $addresses = auth()->user()->addresses->toArray();
        //dd($addresses);
        $where = [];
        //取出地址代号
        foreach ($addresses as $address) {
            $where[] = $address['area'];
            $where[] = $address['city'];
            $where[] = $address['province'];
        }
        $res = DB::table('mbl_region')->whereIn('id', $where)->get()->toArray();
        $addr_name = array_column($res, 'name', 'id');
        $tmp = $addresses;
        foreach ($tmp as $key=>$item) {
            if (isset($addr_name[$item['area']]) && !empty($addr_name[$item['area']])) {
               $addresses[$key]['area'] = $addr_name[$item['area']];
            }
            if (isset($addr_name[$item['city']]) && !empty($addr_name[$item['city']])) {
                $addresses[$key]['city'] = $addr_name[$item['city']];
            }
            if (isset($addr_name[$item['province']]) && !empty($addr_name[$item['province']])) {
                $addresses[$key]['province'] = $addr_name[$item['province']];
            }
        }
        return $addresses;
    }
}