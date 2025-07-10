<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\DataTables\Admin\UserManagement\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:User Management User (Index)', only: ['index']),
            new Middleware('permission:User Management User (Delete)', only: ['destroy']),
        ];
    }

    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.user-management.user.index', [
            'roles' => Role::orderBy('name')->get()
        ]);
    }

    public function store(UserRequest $request)
    {
        $datas = Arr::except($request->validated(), ['password','image','role']);
        if($request->password){
            $datas['password'] = Hash::make($request->password);
        }
        if($request->image){
            $datas['image'] = storeImage($request, 'image', 'User');
        }

        $datas['role']  = Role::find($request->role)->name;

        $user = User::updateOrCreate([
            'id' => $request->id
        ], $datas);

        $user->assignRole($user->role);

        return response()->json(['status' => true]);
    }

    public function edit(string $id)
    {
        $data = User::find($id);
        return response()->json([
            'data' => $data,
            'role' => $data->roles()->first()->id ?? null,
        ]);
    }

    public function destroy(string $id)
    {
        $data = User::withTrashed()->findOrFail($id);

        if ($data->trashed()) {
            $data->restore();
        } else {
            $data->delete();
        }
        return response()->json();
    }
}
