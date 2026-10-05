<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }


    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:100',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:255',

            'password' => 'nullable|min:6|confirmed',
        ]);


        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;


        if ($request->filled('password')) {
            $user->password = $request->password;
        }


        $user->save();


        return back()->with(
            'success',
            'Cập nhật thông tin thành công.'
        );
    }
}