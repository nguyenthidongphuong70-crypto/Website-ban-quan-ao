<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function showChangePassword()
{
    return view('profile.change-password');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ], [
        'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
        'password.required' => 'Vui lòng nhập mật khẩu mới.',
        'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
        'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
    ]);

    $user = $request->user();

    // Kiểm tra mật khẩu cũ
    if (! Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Mật khẩu hiện tại không chính xác.'
        ]);
    }

    // Không cho mật khẩu mới giống mật khẩu cũ
    if (Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'password' => 'Mật khẩu mới phải khác mật khẩu hiện tại.'
        ]);
    }

    // Hash mật khẩu mới
    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with(
        'success',
        'Đổi mật khẩu thành công.'
    );
}
}
