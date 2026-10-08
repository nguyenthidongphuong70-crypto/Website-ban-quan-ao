<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - AUREN</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;

            background: linear-gradient(rgba(60, 45, 35, .35), rgba(60, 45, 35, .35)),
            url('{{ asset("images/login-bg.jpg") }}');

            background-size: cover;
            background-position: center;
        }

        .login-wrapper {
            width: 1120px;
            min-height: 670px;
            background: white;
            display: grid;
            grid-template-columns: 59% 41%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }

        /* ================= LEFT ================= */

        .left {
            position: relative;
            color: white;
            padding: 32px 42px;

            background: linear-gradient(rgba(0, 0, 0, .15),
                rgba(0, 0, 0, .45)),
            url('{{ asset("images/login-bg.jpg") }}');

            background-size: cover;
            background-position: center;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: Georgia, serif;
            letter-spacing: 3px;
            font-size: 22px;
        }

        .nav {
            display: flex;
            gap: 22px;
        }

        .nav a {
            color: white;
            text-decoration: none;
            font-size: 11px;
        }

        .hero {
            width: 350px;
            margin-top: 70px;
        }

        .hero h1 {
            font-family: "Times New Roman", Times, serif;
            font-size: 47px;
            font-weight: 400;
            line-height: 1.12;
            letter-spacing: 0;
            word-spacing: 0;
            margin-bottom: 18px;
        }

        .hero p {
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 24px;
            color: rgba(255, 255, 255, .92);
        }

        .explore {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, .8);
            padding: 12px 21px;
            border-radius: 30px;
            font-size: 12px;
        }

        .features {
            border-top: 1px solid rgba(255, 255, 255, .25);
            padding-top: 19px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .feature i {
            font-size: 17px;
        }

        .feature strong {
            display: block;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .feature span {
            display: block;
            font-size: 9px;
            color: rgba(255, 255, 255, .78);
        }


        /* ================= RIGHT ================= */

        .right {
            padding: 30px 52px;
            background: #fff;
        }

        .register-top {
            text-align: right;
            font-size: 11px;
            color: #888;
        }

        .register-top a {
            color: #222;
            font-weight: bold;
            text-decoration: underline;
        }

        .form-box {
            margin-top: 73px;
        }

        .form-box h2 {
            font-family: Georgia, serif;
            font-size: 38px;
            font-weight: normal;
            margin-bottom: 8px;
            color: #222;
        }

        .subtitle {
            color: #999;
            font-size: 12px;
            margin-bottom: 28px;
        }

        .input-box {
            position: relative;
            margin-bottom: 13px;
        }

        .input-box input {
            width: 100%;
            height: 46px;
            border: none;
            outline: none;
            border-radius: 8px;
            background: #f4f3f1;
            padding: 0 43px;
            font-size: 12px;
        }

        .input-box .left-icon {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #777;
            font-size: 13px;
        }

        .eye {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 13px;
            color: #777;
            cursor: pointer;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            margin: 12px 0 19px;
        }

        .options label {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .options a {
            color: #333;
            text-decoration: none;
        }

        .login-button {
            width: 100%;
            height: 47px;
            border: none;
            border-radius: 25px;
            background: #171715;
            color: white;
            cursor: pointer;
            font-size: 13px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 23px 0 18px;
            font-size: 10px;
            color: #aaa;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e7e7e7;
        }

        .social {
            width: 100%;
            height: 43px;
            border-radius: 25px;
            border: 1px solid #e4e4e4;
            background: white;
            margin-bottom: 11px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 12px;
            text-decoration: none;
            color: #222;
        }

        .google {
            color: #4285f4;
        }

        .facebook {
            color: #1877f2;
        }

        .instagram {
            color: #e1306c;
        }

        .terms {
            text-align: center;
            font-size: 9px;
            line-height: 1.6;
            color: #aaa;
            margin-top: 19px;
        }

        .terms a {
            color: #666;
        }

        @media (max-width: 900px) {
            .login-wrapper {
                width: 95%;
                grid-template-columns: 1fr;
            }

            .left {
                display: none;
            }

            .right {
                padding: 35px 25px;
            }

            .form-box {
                margin-top: 40px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- BÊN TRÁI -->
        <section class="left">

            <div>
                <div class="header">

                    <div class="logo">
                        ♧ AUREN
                    </div>

                    <nav class="nav">
                        <a href="/">Trang chủ</a>
                        <a href="#">Sản phẩm</a>
                        <a href="#">Bộ sưu tập</a>
                        <a href="#">Về chúng tôi</a>
                    </nav>

                </div>

                <div class="hero">

                    <h1>
                        Thời trang<br>
                        cho phiên bản<br>
                        tốt hơn của bạn
                    </h1>

                    <p>
                        Những thiết kế hiện đại, chất lượng cao,
                        đồng hành cùng phong cách sống năng động.
                    </p>

                    <a class="explore" href="#">
                        Khám phá ngay
                        <span>→</span>
                    </a>

                </div>
            </div>

            <div class="features">

                <div class="feature">
                    <i class="fa-regular fa-gem"></i>
                    <div>
                        <strong>Chất liệu cao cấp</strong>
                        <span>Thoải mái mỗi ngày</span>
                    </div>
                </div>

                <div class="feature">
                    <i class="fa-solid fa-truck"></i>
                    <div>
                        <strong>Giao hàng toàn quốc</strong>
                        <span>Nhanh chóng, tiện lợi</span>
                    </div>
                </div>

                <div class="feature">
                    <i class="fa-solid fa-shield-halved"></i>
                    <div>
                        <strong>Đổi trả dễ dàng</strong>
                        <span>An tâm mua sắm</span>
                    </div>
                </div>

            </div>

        </section>


        <!-- BÊN PHẢI -->
        <section class="right">

            <div class="register-top">
                Chưa có tài khoản?
                <a href="{{ route('register') }}">Đăng ký ngay</a>
            </div>

            <div class="form-box">

                <h2>Đăng nhập</h2>

                <p class="subtitle">
                    Tiếp tục hành trình thời trang cùng AUREN
                </p>
                @if ($errors->any())
                <div style="
        background:#ffe8e8;
        color:#b42318;
        padding:10px;
        margin-bottom:15px;
        border-radius:7px;
        font-size:12px;
    ">
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="input-box">

                        <i class="fa-regular fa-envelope left-icon"></i>

                        <input
                            type="text"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="Email hoặc số điện thoại"
                            required>
                    </div>


                    <div class="input-box">

                        <i class="fa-solid fa-lock left-icon"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Mật khẩu"
                            required>

                        <i
                            class="fa-regular fa-eye eye"
                            onclick="togglePassword()">
                        </i>

                    </div>


                    <div class="options">

                        <label>

                            <input type="checkbox" name="remember">
                            Ghi nhớ đăng nhập

                        </label>

                        <a href="{{ route('password.request') }}"
                            style="font-size:12px; color:#555; text-decoration:none;">
                            Quên mật khẩu?
                        </a>

                    </div>


                    <button type="submit" class="login-button">

                        Đăng nhập &nbsp; →

                    </button>

                </form>


                <div class="divider">
                    Hoặc đăng nhập với
                </div>


                <a href="{{ route('social.redirect', 'google') }}"
                    class="social">

                    <i class="fa-brands fa-google google"></i>

                    Tiếp tục với Google

                </a>


                <a href="{{ route('social.redirect', 'facebook') }}"
                    class="social">

                    <i class="fa-brands fa-facebook facebook"></i>

                    Tiếp tục với Facebook

                </a>


                <a href="{{ route('social.redirect', 'instagram') }}"
                    class="social">

                    <i class="fa-brands fa-instagram instagram"></i>

                    Tiếp tục với Instagram

                </a>


                <div class="terms">

                    Bằng việc đăng nhập, bạn đồng ý với

                    <a href="#">Điều khoản dịch vụ</a>

                    và

                    <a href="#">Chính sách bảo mật</a>

                    của AUREN.

                </div>

            </div>

        </section>

    </div>


    <script>
        function togglePassword() {

            const password =
                document.getElementById('password');

            if (password.type === 'password') {

                password.type = 'text';

            } else {

                password.type = 'password';

            }

        }
    </script>

</body>

</html>