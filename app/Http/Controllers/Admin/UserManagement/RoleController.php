<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\DataTables\Admin\UserManagement\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:User Management Role (Index)', only: ['index']),
            new Middleware('permission:User Management Role (Delete)', only: ['destroy']),
            new Middleware('permission:User Management Role (Permission)', only: ['show','update']),
        ];
    }

    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('admin.user-management.role.index');
    }

    public function store(RoleRequest $request)
    {
        Role::updateOrCreate([
            'id' => $request->id
        ],[
            'name' => $request->name
        ]);

        return response()->json(['status' => true]);
    }

    public function show($id){
        $role           = Role::find($id);
        $data           = Permission::orderBy('name')->get();
        $permissions    = $data->pluck('name')->toArray();
        $permissions_id = $data->pluck('id')->toArray();
        $groups         = [];
        
        foreach ($permissions as $permission) {
            $parts = explode(' (', $permission);
            $title = $parts[0];
            $subtitle = rtrim($parts[1], ')');
            $groups[$title][] = $subtitle;
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('admin.user-management.role.permission',compact('role','groups','rolePermissions','permissions_id'))->with('i');
    }

    public function edit(string $id)
    {
        $data = Role::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $permissions = $request->permission;
        $updatedPermissions = array_map(function($value) {
            return str_replace('-', '(', $value);
        }, $permissions);
        $role = Role::find($id);
        $role->syncPermissions($updatedPermissions);
        return back()->with('success','Role updated successfully');
    }

    public function destroy(string $id)
    {
        Role::findOrFail($id)->delete();
        return response()->json();
    }
}
