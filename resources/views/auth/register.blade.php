<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tạo tài khoản - AUREN</title>

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

            padding: 20px;

            background: linear-gradient(rgba(60, 45, 35, .35),
                rgba(60, 45, 35, .35)),
            url('{{ asset("images/register-bg.jpg") }}');

            background-size: cover;
            background-position: center;
        }


        .register-wrapper {

            width: 1200px;
            min-height: 720px;

            display: grid;
            grid-template-columns: 62% 38%;

            background: white;

            border-radius: 20px;
            overflow: hidden;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, .25);
        }


        /* ================= LEFT ================= */

        .left {

            position: relative;

            padding: 32px 42px;

            color: white;

            background: linear-gradient(rgba(0, 0, 0, .12),
                rgba(0, 0, 0, .42)),
            url('{{ asset("images/register-bg.jpg") }}');

            background-size: cover;
            background-position: center;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }


        .header {

            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        .logo {

            font-family: Georgia, serif;

            font-size: 22px;
            letter-spacing: 3px;
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

            width: 360px;

            margin-top: 55px;
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

            margin-bottom: 23px;
        }


        .explore {

            display: inline-flex;

            align-items: center;

            gap: 15px;

            padding: 12px 20px;

            border: 1px solid rgba(255, 255, 255, .8);

            border-radius: 30px;

            color: white;

            text-decoration: none;

            font-size: 12px;
        }


        .features {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 15px;

            border-top:
                1px solid rgba(255, 255, 255, .25);

            padding-top: 18px;
        }


        .feature {

            display: flex;

            align-items: center;

            gap: 9px;
        }


        .feature i {

            font-size: 18px;
        }


        .feature strong {

            display: block;

            font-size: 10px;

            margin-bottom: 3px;
        }


        .feature span {

            display: block;

            font-size: 9px;

            opacity: .8;
        }



        /* ================= RIGHT ================= */

        .right {

            background: #f7efe5;

            padding: 25px 45px;
        }


        .login-top {

            text-align: right;

            font-size: 10px;

            color: #777;
        }


        .login-top a {

            color: #222;

            font-weight: bold;

            text-decoration: underline;
        }


        .form-box {

            margin-top: 25px;
        }


        .form-box h2 {

            font-family: Georgia, serif;

            font-size: 34px;

            font-weight: normal;

            color: #222;

            margin-bottom: 6px;
        }


        .subtitle {

            font-size: 11px;

            color: #888;

            margin-bottom: 16px;
        }


        /* SOCIAL */

        .social-row {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 8px;
        }


        .social {
            height: 53px;

            border: none;
            border-radius: 5px;

            background: rgba(255, 255, 255, .65);

            cursor: pointer;

            font-size: 9px;

            text-decoration: none;
            color: #222;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }


        .social i {

            display: block;

            margin-bottom: 4px;

            font-size: 17px;
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


        .divider {

            display: flex;

            align-items: center;

            gap: 10px;

            margin: 15px 0;

            color: #999;

            font-size: 9px;
        }


        .divider::before,
        .divider::after {

            content: "";

            height: 1px;

            flex: 1;

            background: #ddd;
        }


        /* INPUT */

        .input-box {

            position: relative;

            margin-bottom: 9px;
        }


        .input-box input {

            width: 100%;

            height: 41px;

            border: none;

            outline: none;

            background:
                rgba(255, 255, 255, .58);

            border-radius: 4px;

            padding: 0 40px;

            font-size: 11px;
        }


        .left-icon {

            position: absolute;

            left: 13px;

            top: 13px;

            color: #777;

            font-size: 12px;
        }


        .eye {

            position: absolute;

            right: 13px;

            top: 13px;

            color: #777;

            font-size: 12px;

            cursor: pointer;
        }


        /* GENDER */

        .gender-title {

            font-size: 10px;

            margin: 10px 0 7px;
        }


        .gender {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 7px;

            margin-bottom: 11px;
        }


        .gender label {

            height: 37px;

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 5px;

            background:
                rgba(255, 255, 255, .58);

            border-radius: 4px;

            font-size: 10px;
        }


        .agree {

            font-size: 9px;

            line-height: 1.5;

            color: #666;

            margin-bottom: 12px;
        }


        .register-button {

            width: 100%;

            height: 44px;

            border: none;

            border-radius: 25px;

            background: #211f1a;

            color: white;

            font-size: 12px;

            cursor: pointer;
        }


        @media(max-width: 900px) {

            .register-wrapper {

                width: 95%;

                grid-template-columns: 1fr;
            }

            .left {

                display: none;
            }

            .right {

                padding: 30px 25px;
            }
        }
    </style>
</head>


<body>


    <div class="register-wrapper">


        <!-- BÊN TRÁI -->

        <section class="left">


            <div>


                <div class="header">


                    <div class="logo">

                        ♧ AUREN

                    </div>


                    <nav class="nav">

                        <a href="/">
                            Trang chủ
                        </a>

                        <a href="#">
                            Sản phẩm
                        </a>

                        <a href="#">
                            Bộ sưu tập
                        </a>

                        <a href="#">
                            Ưu đãi
                        </a>

                        <a href="#">
                            Về chúng tôi
                        </a>

                    </nav>


                </div>



                <div class="hero">


                    <h1>Thời trang<br>đơn giản<br>cho phiên bản<br>tốt hơn của bạn</h1>

                    <p>

                        Những thiết kế hiện đại, dễ phối,
                        đồng hành cùng phong cách sống năng động.

                    </p>


                    <a href="#" class="explore">

                        Khám phá ngay

                        <span>→</span>

                    </a>


                </div>


            </div>



            <div class="features">


                <div class="feature">

                    <i class="fa-solid fa-truck"></i>

                    <div>

                        <strong>
                            Giao hàng toàn quốc
                        </strong>

                        <span>
                            Nhanh chóng, tiện lợi
                        </span>

                    </div>

                </div>



                <div class="feature">

                    <i class="fa-solid fa-shield-halved"></i>

                    <div>

                        <strong>
                            Đổi trả dễ dàng
                        </strong>

                        <span>
                            Trong 7 ngày
                        </span>

                    </div>

                </div>



                <div class="feature">

                    <i class="fa-regular fa-gem"></i>

                    <div>

                        <strong>
                            Chất liệu cao cấp
                        </strong>

                        <span>
                            Thoải mái mỗi ngày
                        </span>

                    </div>

                </div>


            </div>


        </section>



        <!-- BÊN PHẢI -->

        <section class="right">


            <div class="login-top">

                Đã có tài khoản?

                <a href="{{ route('login') }}">

                    Đăng nhập

                </a>

            </div>



            <div class="form-box">


                <h2>
                    Tạo tài khoản mới
                </h2>


                <p class="subtitle">

                    Chỉ mất 1 phút để bắt đầu hành trình thời trang cùng AUREN

                </p>



                <div class="social-row">

                    <a href="{{ route('social.redirect', 'google') }}"
                        class="social">

                        <i class="fa-brands fa-google google"></i>
                        Đăng ký với Google

                    </a>


                    <a href="{{ route('social.redirect', 'facebook') }}"
                        class="social">

                        <i class="fa-brands fa-facebook facebook"></i>
                        Đăng ký với Facebook

                    </a>


                    <a href="{{ route('social.redirect', 'instagram') }}"
                        class="social">

                        <i class="fa-brands fa-instagram instagram"></i>
                        Đăng ký với Instagram

                    </a>

                </div>



                <div class="divider">

                    Hoặc đăng ký bằng email

                </div>

                @if ($errors->any())
                <div style="
        background:#ffe8e8;
        color:#b42318;
        padding:10px;
        margin-bottom:12px;
        border-radius:6px;
        font-size:11px;
    ">
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf


                    <div class="input-box">

                        <i class="fa-regular fa-user left-icon"></i>

                        <input
                            type="text"
                            name="full_name"
                            value="{{ old('full_name') }}"
                            placeholder="Họ và tên *"
                            required>

                    </div>


                    <div class="input-box">

                        <i class="fa-regular fa-envelope left-icon"></i>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email *"
                            required>
                    </div>


                    <div class="input-box">

                        <i class="fa-solid fa-phone left-icon"></i>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Số điện thoại">

                    </div>


                    <div class="input-box">

                        <i class="fa-solid fa-lock left-icon"></i>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Mật khẩu *"
                            required>

                        <i
                            class="fa-regular fa-eye eye"
                            onclick="togglePassword('password')">
                        </i>

                    </div>


                    <div class="input-box">

                        <i class="fa-solid fa-lock left-icon"></i>

                        <input
                            id="confirmPassword"
                            type="password"
                            name="password_confirmation"
                            placeholder="Xác nhận mật khẩu *"
                            required>

                        <i
                            class="fa-regular fa-eye eye"
                            onclick="togglePassword('confirmPassword')">
                        </i>

                    </div>


                    <div class="input-box">

                        <i class="fa-regular fa-calendar left-icon"></i>

                        <input type="date">

                    </div>



                    <div class="gender-title">

                        Giới tính

                    </div>


                    <div class="gender">


                        <label>

                            <input
                                type="radio"
                                name="gender">

                            Nam

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="gender">

                            Nữ

                        </label>


                        <label>

                            <input
                                type="radio"
                                name="gender">

                            Khác

                        </label>


                    </div>



                    <div class="agree">

                        <label>

                            <input type="checkbox">

                            Tôi đồng ý với

                            <u>Điều khoản dịch vụ</u>

                            và

                            <u>Chính sách bảo mật</u>

                            của AUREN

                        </label>

                    </div>



                    <button
                        type="submit"
                        class="register-button">

                        Tạo tài khoản mới &nbsp; →

                    </button>


                </form>


            </div>


        </section>


    </div>



    <script>
        function togglePassword(id) {

            const input =
                document.getElementById(id);

            if (input.type === "password") {

                input.type = "text";

            } else {

                input.type = "password";

            }

        }
    </script>


</body>

</html>