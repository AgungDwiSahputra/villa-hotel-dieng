<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request): RedirectResponse
    {
    
        $datas = Arr::except($request->validated(), ['password','image','role']);
        if($request->password){
            $datas['password'] = Hash::make($request->password);
        }
        if($request->image){
            $datas['image'] = storeImage($request, 'image', 'User');
        }
        
        $user = User::updateOrCreate([
            'id' => $request->id
        ], $datas);

        $user->assignRole('User');

        event(new Registered($user));

        Auth::login($user);
        return redirect(route('home', absolute: false))->with('success','Register Successfully');
    }
}
