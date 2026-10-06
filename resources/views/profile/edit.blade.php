<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân - AUREN</title>

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
            background: #f5efe8;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .profile-wrapper {
            width: 900px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 32% 68%;
            box-shadow: 0 15px 45px rgba(0,0,0,.12);
        }

        .left {
            background: #1d1c19;
            color: white;
            padding: 45px 30px;
            text-align: center;
        }

        .logo {
            font-family: Georgia, serif;
            letter-spacing: 3px;
            font-size: 25px;
            margin-bottom: 45px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f0e7dc;
            color: #222;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 40px;
            margin-bottom: 20px;
        }

        .left h3 {
            font-family: Georgia, serif;
            font-size: 21px;
            font-weight: normal;
            margin-bottom: 8px;
        }

        .left p {
            font-size: 12px;
            color: #ccc;
            margin-bottom: 6px;
        }

        .role {
            display: inline-block;
            margin-top: 12px;
            padding: 7px 15px;
            background: rgba(255,255,255,.12);
            border-radius: 20px;
            font-size: 11px;
        }

        .logout-form {
            margin-top: 40px;
        }

        .logout-btn {
            width: 100%;
            height: 42px;
            border-radius: 22px;
            border: 1px solid rgba(255,255,255,.35);
            background: transparent;
            color: white;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: white;
            color: #222;
        }

        .right {
            padding: 45px 55px;
        }

        .right h1 {
            font-family: Georgia, serif;
            font-size: 34px;
            font-weight: normal;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 12px;
            color: #999;
            margin-bottom: 28px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-size: 11px;
            margin-bottom: 7px;
            color: #555;
        }

        .input-box {
            position: relative;
        }

        .input-box i {
            position: absolute;
            left: 14px;
            top: 14px;
            color: #777;
            font-size: 12px;
        }

        .input-box input {
            width: 100%;
            height: 43px;
            border: 1px solid #eee;
            background: #f7f6f4;
            border-radius: 7px;
            outline: none;
            padding: 0 14px 0 40px;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .save-btn {
            width: 100%;
            height: 45px;
            margin-top: 10px;
            border: none;
            border-radius: 24px;
            background: #1d1c19;
            color: white;
            cursor: pointer;
        }

        .success {
            background: #e8f8ec;
            color: #187a38;
            padding: 10px;
            border-radius: 7px;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .error {
            background: #ffe9e9;
            color: #b42318;
            padding: 10px;
            border-radius: 7px;
            margin-bottom: 15px;
            font-size: 12px;
        }

        @media(max-width: 750px) {
            .profile-wrapper {
                grid-template-columns: 1fr;
            }

            .two-column {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="profile-wrapper">

    <div class="left">

        <div class="logo">
            ♧ AUREN
        </div>

        <div class="avatar">
            <i class="fa-regular fa-user"></i>
        </div>

        <h3>{{ $user->full_name }}</h3>

        <p>{{ $user->email }}</p>

        @if($user->phone)
            <p>{{ $user->phone }}</p>
        @endif

        <div class="role">
            {{ $user->role }}
        </div>

        <form action="{{ route('logout') }}"
              method="POST"
              class="logout-form">

            @csrf

            <button type="submit"
                    class="logout-btn">

                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                &nbsp; Đăng xuất

            </button>

        </form>

    </div>


    <div class="right">

        <h1>Thông tin cá nhân</h1>

        <p class="subtitle">
            Xem và cập nhật thông tin tài khoản của bạn
        </p>


        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif


        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif


        <form action="{{ route('profile.update') }}" method="POST">

            @csrf
            @method('PUT')


            <div class="input-group">
                <label>Họ và tên</label>

                <div class="input-box">
                    <i class="fa-regular fa-user"></i>

                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name', $user->full_name) }}"
                        required>
                </div>
            </div>


            <div class="input-group">
                <label>Email</label>

                <div class="input-box">
                    <i class="fa-regular fa-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required>
                </div>
            </div>


            <div class="two-column">

                <div class="input-group">
                    <label>Số điện thoại</label>

                    <div class="input-box">
                        <i class="fa-solid fa-phone"></i>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>


                <div class="input-group">
                    <label>Địa chỉ</label>

                    <div class="input-box">
                        <i class="fa-solid fa-location-dot"></i>

                        <input
                            type="text"
                            name="address"
                            value="{{ old('address', $user->address) }}">
                    </div>
                </div>

            </div>


            <div class="two-column">

                <div class="input-group">
                    <label>Mật khẩu mới</label>

                    <div class="input-box">
                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            name="password"
                            placeholder="Không đổi thì để trống">
                    </div>
                </div>


                <div class="input-group">
                    <label>Xác nhận mật khẩu</label>

                    <div class="input-box">
                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Nhập lại mật khẩu mới">
                    </div>
                </div>

            </div>


            <button type="submit" class="save-btn">
                Lưu thay đổi →
            </button>

        </form>

    </div>

</div>

</body>
</html>