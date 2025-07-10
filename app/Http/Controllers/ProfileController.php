<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->image){
            $user->image = storeImage($request, 'image', 'User');
        }
        $user->save();

        return back()->with('success', 'Update Profile Successfully');
    }

public function destroy(Request $request): RedirectResponse
{
    $inputPassword = $request->input('password');
    $hashedPassword = Auth::user()->password;
    if (Hash::check($inputPassword, $hashedPassword)) {
        $user = User::find(Auth::user()->id);
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }

    return back()->withErrors(['password' => 'The provided password is incorrect.']);
}

}
