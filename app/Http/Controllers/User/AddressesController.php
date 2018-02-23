<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressesController extends Controller
{

    protected $response = [
        'code' => 1,
        'msg' => '服务器异常，请稍后再试',
    ];

    public function index()
    {
        $data = $this->getUserAddress();
        return view('user.addresses.index', compact('data'));
    }


    public function store(AddressRequest $request)
    {
        $addressesData = $this->getFormatRequest($request);
        $this->guard()->user()->addresses()->create($addressesData);

        return back()->with('status', '创建成功');
    }


    public function edit(Address $address)
    {
        $province = $address->province;
        $city = $address->city;
        $data = $this->getUserAddress($province, $city);
        return view('user.addresses.edit', compact('address', 'data'));
    }


    public function update(AddressRequest $request, Address $address)
    {
        $this->checkPermission($address->user_id);

        $addressesData = $this->getFormatRequest($request);

        $address->update($addressesData);

        return back()->with('status', '修改成功');
    }

    public function destroy(Address $address)
    {
        if ($this->owns($address->user_id)) {
            return $this->response;
        }

        if ($address->delete()) {
            $this->response = ['code' => 0, 'msg' => '删除成功'];
        }

        return $this->response;
    }

    public function setDefaultAddress(Address $address)
    {
        if (!$this->owns($address->user_id)) {
            return $this->response;
        }

        Address::where('user_id', $address->user_id)->update(['is_default' => 0]);
        $address->is_default = 1;

        if ($address->save()) {
            $this->response = [
                'code' => 0,
                'msg' => '设置成功',
            ];
        }

        return $this->response;
    }

    protected function checkPermission($userID)
    {
        if (!$this->owns($userID)) {
            abort(404, '你没有权限');
        }
    }

    protected function owns($userID)
    {
        return $this->guard()->user()->id == $userID;
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function getFormatRequest($request)
    {
        return $request->only(['name', 'phone', 'province', 'city', 'detail_address', 'area',]);
    }


    public function getRegion($pid)
    {
        return DB::table('mbl_region')->where('pid', $pid)->get();
    }

    public function show(Address $address)
    {
        return $address;
    }

    public function getUserAddress($province = null, $city = null)
    {
        $addresses = $this->guard()->user()->addresses;
        $where = [];
        foreach ($addresses->toArray() as $address) {
            $where[] = $address['area'];
            $where[] = $address['city'];
            $where[] = $address['province'];
        }
        $addr_name = DB::table('mbl_region')->whereIn('id', $where)->get()->toArray();
        $addr_name = array_column($addr_name, 'name', 'id');
        // Provincial and municipal regions
        $provinces = DB::table('mbl_region')->where('pid', 1)->get();
        if (empty($province) && empty($city)) {
            $cities = DB::table('mbl_region')->where('pid', $provinces->first()->id)->get();
            $areas = DB::table('mbl_region')->where('pid', $cities->first()->id)->get();
        } else {
            $cities = DB::table('mbl_region')->where('pid', $province)->get();
            $areas = DB::table('mbl_region')->where('pid', $city)->get();
        }

        return ['cities' => $cities, 'provinces' => $provinces, 'areas' => $areas, 'addr_name' => $addr_name, 'addresses' => $addresses];
    }
}
