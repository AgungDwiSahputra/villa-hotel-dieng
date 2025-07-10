<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\DataTables\Admin\UserManagement\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:User Management Permission (Index)', only: ['index']),
            new Middleware('permission:User Management Permission (Delete)', only: ['destroy']),
        ];
    }

    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('admin.user-management.permission.index');
    }

    public function store(PermissionRequest $request)
    {
        Permission::updateOrCreate(['id'    => $request->id],[
            'name'          => $request->module.' ('.$request->module_action.')',
            'guard_name'    => 'web',
        ]);
        return response()->json([
            'status' => true,
        ]);
    }

    public function edit(string $id)
    {
        $data = Permission::find($id);
        $permission = [
            'id'            => $data->id,
            'module'         => substr($data->name, 0, strpos($data->name, '(')),
            'module_action'  => substr($data->name, strpos($data->name, '(')+1, -1),
        ];
        return response()->json([
            'data'  => $permission
        ]);
    }

    public function destroy(string $id)
    {
        Permission::findOrFail($id)->delete();
        return response()->json();
    }
}
