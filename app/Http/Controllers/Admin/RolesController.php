<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /*
     * 显示一个资源的列表
     * */
    public function index()
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.roles.index', compact('roles'));
    }

    /*
     * 显示一个表单来创建一个新的资源
     * */
    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    /*
     * 保存最新创建的资源
     * */
    public function store(RoleRequest $request)
    {
        $roleData = $request->only('name');
        $roleData['guard_name'] = 'admin';
        $role = Role::create($roleData);

        array_map(function ($item) use ($role) {
            $role->givePermissionTo($item['name']);
        }, $request->input('permission'));

        return back()->with('status', '创建角色成功');
    }

    public function show(Role $role)
    {
        return $role;
    }

    /*
     *  显示一个表单来编辑指定的资源
     * */
    public function edit(Role $role)
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /*
     * 更新指定的资源
     * */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only('name'));
        //将多个权限同步赋予到一个角色：
        $role->syncPermissions($request->input('permission'));

        return back()->with('status', '修改角色成功');
    }

    /*
     *  删除指定的资源
     * */
    public function destroy(Role $role)
    {
        if ($role->delete()) {
            return ['msg' => '删除成功', 'code' => 200];
        } else {
            return ['msg' => '删除失败', 'code' => 401];
        }
    }
}
