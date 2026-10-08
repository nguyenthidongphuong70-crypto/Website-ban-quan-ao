<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // ==============================
    // 1. TRANG NHẬP EMAIL
    // ==============================
    public function showPhoneForm()
    {
        // Giữ tên hàm này để không phải sửa route hiện tại
        return view('auth.forgot-password');
    }


    // ==============================
    // 2. TẠO VÀ GỬI OTP QUA GMAIL
    // ==============================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
        ]);

        // Chuẩn hóa email
        $email = strtolower(trim($request->email));

        // Tìm user theo email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Email chưa được đăng ký.'
                ])
                ->withInput();
        }

        // Tạo OTP 6 số
        $otp = random_int(100000, 999999);

        // Lưu OTP vào session
        // OTP có hiệu lực 5 phút
        session([
            'reset_user_id' => $user->id,
            'reset_email' => $user->email,
            'reset_otp' => (string) $otp,
            'reset_otp_expire' => now()->addMinutes(5)->timestamp,
            'otp_verified' => false,
        ]);

        // ==============================
        // GỬI OTP THẬT QUA GMAIL
        // ==============================
        try {

            Mail::raw(
                "Xin chào {$user->full_name},\n\n"
                . "Mã OTP đặt lại mật khẩu AUREN của bạn là:\n\n"
                . "{$otp}\n\n"
                . "Mã OTP có hiệu lực trong 5 phút.\n\n"
                . "Nếu bạn không yêu cầu đặt lại mật khẩu, "
                . "vui lòng bỏ qua email này.",
                function ($message) use ($user) {

                    $message
                        ->to($user->email)
                        ->subject('Mã OTP đặt lại mật khẩu - AUREN');
                }
            );

        } catch (\Throwable $e) {

            // Nếu gửi mail thất bại thì xóa OTP
            session()->forget([
                'reset_user_id',
                'reset_email',
                'reset_otp',
                'reset_otp_expire',
                'otp_verified',
            ]);

            return back()
                ->withErrors([
                    'email' => 'Không thể gửi mã OTP. Vui lòng thử lại.'
                ])
                ->withInput();
        }

        return redirect()
            ->route('password.otp.form')
            ->with(
                'success',
                'Mã OTP đã được gửi đến Gmail của bạn.'
            );
    }


    // ==============================
    // 3. TRANG NHẬP OTP
    // ==============================
    public function showOtpForm()
    {
        if (
            !session()->has('reset_user_id') ||
            !session()->has('reset_otp')
        ) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Vui lòng yêu cầu mã OTP trước.'
                ]);
        }

        return view('auth.verify-otp');
    }


    // ==============================
    // 4. KIỂM TRA OTP
    // ==============================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.digits' => 'OTP phải gồm đúng 6 chữ số.',
        ]);

        // Không có OTP trong session
        if (!session()->has('reset_otp')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Phiên OTP không tồn tại. Vui lòng gửi lại OTP.'
                ]);
        }

        // Kiểm tra OTP hết hạn
        if (
            !session()->has('reset_otp_expire') ||
            now()->timestamp > session('reset_otp_expire')
        ) {
            session()->forget([
                'reset_otp',
                'reset_otp_expire',
                'otp_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Mã OTP đã hết hạn. Vui lòng lấy mã mới.'
                ]);
        }

        // Kiểm tra OTP sai
        if (
            (string) $request->otp !==
            (string) session('reset_otp')
        ) {
            return back()
                ->withErrors([
                    'otp' => 'Mã OTP không chính xác.'
                ]);
        }

        // OTP đúng
        session([
            'otp_verified' => true,
        ]);

        // OTP chỉ được dùng 1 lần
        session()->forget([
            'reset_otp',
            'reset_otp_expire',
        ]);

        return redirect()
            ->route('password.reset.form')
            ->with(
                'success',
                'Xác nhận OTP thành công.'
            );
    }


    // ==============================
    // 5. TRANG ĐẶT MẬT KHẨU MỚI
    // ==============================
    public function showResetForm()
    {
        if (
            !session('otp_verified') ||
            !session()->has('reset_user_id')
        ) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Bạn cần xác nhận OTP trước.'
                ]);
        }

        return view('auth.reset-password');
    }


    // ==============================
    // 6. CẬP NHẬT MẬT KHẨU MỚI
    // ==============================
    public function resetPassword(Request $request)
    {
        // Không được đổi mật khẩu nếu chưa xác minh OTP
        if (
            !session('otp_verified') ||
            !session()->has('reset_user_id')
        ) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Phiên đặt lại mật khẩu không hợp lệ.'
                ]);
        }

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ],
        ], [
            'password.required' =>
                'Vui lòng nhập mật khẩu mới.',

            'password.min' =>
                'Mật khẩu phải có ít nhất 6 ký tự.',

            'password.confirmed' =>
                'Mật khẩu xác nhận không trùng khớp.',
        ]);

        // Tìm user
        $user = User::find(
            session('reset_user_id')
        );

        if (!$user) {

            session()->forget([
                'reset_user_id',
                'reset_email',
                'reset_otp',
                'reset_otp_expire',
                'otp_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Không tìm thấy tài khoản.'
                ]);
        }

        // ==============================
        // HASH MẬT KHẨU TRƯỚC KHI LƯU
        // ==============================
        $user->password = Hash::make(
            $request->password
        );

        $user->save();

        // Xóa toàn bộ session quên mật khẩu
        session()->forget([
            'reset_user_id',
            'reset_email',
            'reset_otp',
            'reset_otp_expire',
            'otp_verified',
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Đổi mật khẩu thành công. '
                . 'Vui lòng đăng nhập bằng mật khẩu mới.'
            );
    }
}