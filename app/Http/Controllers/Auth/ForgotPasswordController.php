<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    // =========================
    // 1. TRANG NHẬP SỐ ĐIỆN THOẠI
    // =========================
    public function showPhoneForm()
    {
        return view('auth.forgot-password');
    }


    // =========================
    // 2. TẠO VÀ "GỬI" OTP ẢO
    // =========================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
        ]);

        // Chuẩn hóa số điện thoại
        $phone = $this->normalizePhone($request->phone);

        // Tìm tài khoản theo số điện thoại
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'phone' => 'Số điện thoại chưa được đăng ký.'
                ])
                ->withInput();
        }

        // Tạo OTP 6 số
        $otp = random_int(100000, 999999);

        // Lưu OTP vào session, hiệu lực 5 phút
        session([
            'reset_user_id' => $user->id,
            'reset_phone' => $phone,
            'reset_otp' => (string) $otp,
            'reset_otp_expire' => now()->addMinutes(5)->timestamp,
            'otp_verified' => false,
        ]);

        // Ghi OTP vào laravel.log
        Log::info('OTP QUEN MAT KHAU', [
            'phone' => $phone,
            'otp' => $otp,
        ]);

        /*
         * Khi chạy local để demo:
         * OTP sẽ hiện ngay trên trang nhập OTP.
         */
        if (app()->environment('local')) {
            session()->flash('demo_otp', $otp);
        }

        return redirect()
            ->route('password.otp.form')
            ->with('success', 'Mã OTP đã được tạo. Mã có hiệu lực trong 5 phút.');
    }


    // =========================
    // 3. TRANG NHẬP OTP
    // =========================
    public function showOtpForm()
    {
        if (!session()->has('reset_user_id') ||
            !session()->has('reset_otp')) {

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'phone' => 'Vui lòng yêu cầu mã OTP trước.'
                ]);
        }

        return view('auth.verify-otp');
    }


    // =========================
    // 4. KIỂM TRA OTP
    // =========================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.digits' => 'OTP phải gồm đúng 6 chữ số.',
        ]);

        // Không tồn tại OTP
        if (!session()->has('reset_otp')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'phone' => 'Phiên OTP không tồn tại. Vui lòng gửi lại OTP.'
                ]);
        }

        // OTP hết hạn
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
                    'phone' => 'Mã OTP đã hết hạn. Vui lòng lấy mã mới.'
                ]);
        }

        // OTP sai
        if ((string) $request->otp !== (string) session('reset_otp')) {
            return back()->withErrors([
                'otp' => 'Mã OTP không chính xác.'
            ]);
        }

        // OTP đúng
        session([
            'otp_verified' => true,
        ]);

        // Không cần giữ OTP nữa
        session()->forget([
            'reset_otp',
            'reset_otp_expire',
        ]);

        return redirect()
            ->route('password.reset.form')
            ->with('success', 'Xác nhận OTP thành công.');
    }


    // =========================
    // 5. TRANG NHẬP MẬT KHẨU MỚI
    // =========================
    public function showResetForm()
    {
        if (!session('otp_verified') ||
            !session()->has('reset_user_id')) {

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'phone' => 'Bạn cần xác nhận OTP trước.'
                ]);
        }

        return view('auth.reset-password');
    }


    // =========================
    // 6. ĐỔI MẬT KHẨU
    // =========================
    public function resetPassword(Request $request)
    {
        if (!session('otp_verified') ||
            !session()->has('reset_user_id')) {

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'phone' => 'Phiên đặt lại mật khẩu không hợp lệ.'
                ]);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp.',
        ]);

        $user = User::find(session('reset_user_id'));

        if (!$user) {
            session()->forget([
                'reset_user_id',
                'reset_phone',
                'otp_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'phone' => 'Không tìm thấy tài khoản.'
                ]);
        }

        // Mã hóa mật khẩu mới
        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa toàn bộ session reset password
        session()->forget([
            'reset_user_id',
            'reset_phone',
            'reset_otp',
            'reset_otp_expire',
            'otp_verified',
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Đổi mật khẩu thành công. Vui lòng đăng nhập bằng mật khẩu mới.'
            );
    }


    // =========================
    // CHUẨN HÓA SỐ ĐIỆN THOẠI
    // +84901234567 -> 0901234567
    // =========================
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '84')) {
            return '0' . substr($phone, 2);
        }

        return $phone;
    }
}