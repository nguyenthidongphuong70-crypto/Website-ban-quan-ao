<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Hiển thị trang đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect('/')
            ->with('success', 'Tạo tài khoản thành công.');
    }

    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->login;

        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';

        if (Auth::attempt([
            $field => $login,
            'password' => $request->password,
        ])) {

            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            // Nếu là Admin -> Vào thẳng trang Dashboard quản trị
            if ($user && $user->isAdmin()) {
                return redirect('/admin/dashboard');
            }

            // Nếu là Khách hàng -> Về trang chủ
            return redirect('/');
        }

        return back()
            ->withErrors([
                'login' => 'Email/số điện thoại hoặc mật khẩu không đúng.',
            ])
            ->onlyInput('login');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook', 'instagram'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback(Request $request, string $provider)
    {
        if (!in_array($provider, ['google', 'facebook', 'instagram'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'login' => 'Đăng nhập bằng ' . ucfirst($provider) . ' thất bại.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | INSTAGRAM
        |--------------------------------------------------------------------------
        */

        if ($provider === 'instagram') {

            $email = 'instagram_'
                . $socialUser->getId()
                . '@auren.local';

            $user = User::firstOrCreate(
                [
                    'email' => $email,
                ],
                [
                    'full_name' =>
                        $socialUser->getNickname()
                        ?: 'Instagram User',

                    'password' => Str::random(40),

                    'role' => 'customer',
                ]
            );

        }

        /*
        |--------------------------------------------------------------------------
        | GOOGLE / FACEBOOK
        |--------------------------------------------------------------------------
        */

        else {

            $email = $socialUser->getEmail();

            if (!$email) {

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'login' => 'Không lấy được email từ tài khoản.'
                    ]);
            }


            $user = User::firstOrCreate(
                [
                    'email' => $email,
                ],
                [
                    'full_name' =>
                        $socialUser->getName()
                        ?: $socialUser->getNickname()
                        ?: 'Khách hàng',

                    'password' => Str::random(40),

                    'role' => 'customer',
                ]
            );
        }


        Auth::login($user, true);

        $request->session()->regenerate();

        // Nếu tài khoản mạng xã hội đăng nhập vào là Admin -> Vào thẳng Dashboard
        if ($user && $user->isAdmin()) {
            return redirect('/admin/dashboard')
                ->with('success', 'Đăng nhập bằng ' . ucfirst($provider) . ' thành công.');
        }

        return redirect('/products')
            ->with(
                'success',
                'Đăng nhập bằng '
                . ucfirst($provider)
                . ' thành công.'
            );
    }
}