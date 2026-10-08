<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Đổi mật khẩu - AUREN</title>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f8f5f0;
            font-family: 'DM Sans', sans-serif;
        }

        .box {
            width: 430px;
            max-width: calc(100% - 30px);

            padding: 45px 40px;

            background: #fff;
            border: 1px solid #e8e0d6;

            box-shadow: 0 15px 45px rgba(0, 0, 0, .06);
        }

        .brand {
            text-align: center;

            font-family: 'Cormorant Garamond', serif;
            font-size: 27px;

            letter-spacing: 7px;

            margin-bottom: 30px;
        }

        h1 {
            margin: 0 0 28px;

            text-align: center;

            font-family: 'Cormorant Garamond', serif;
            font-weight: 400;
            font-size: 32px;
        }

        label {
            display: block;

            margin: 15px 0 7px;

            font-size: 12px;
        }

        input {
            width: 100%;
            height: 48px;

            padding: 0 14px;

            border: 1px solid #ddd6ce;

            font-family: inherit;
            outline: none;
        }

        input:focus {
            border-color: #111;
        }

        .btn {
            width: 100%;
            height: 48px;

            margin-top: 25px;

            background: #111;
            color: #fff;

            border: 0;

            cursor: pointer;

            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .success {
            background: #edf8ef;
            color: #256a31;

            padding: 11px;
            margin-bottom: 15px;

            font-size: 12px;
        }

        .error {
            background: #fff0f0;
            color: #a12626;

            padding: 11px;
            margin-bottom: 15px;

            font-size: 12px;
        }

        .back {
            display: block;

            margin-top: 20px;

            text-align: center;
            text-decoration: none;

            color: #555;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="box">

        <div class="brand">
            ♤ AUREN
        </div>

        <h1>Đổi mật khẩu</h1>


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


        <form
            action="{{ route('profile.password.update') }}"
            method="POST">

            @csrf
            @method('PUT')


            <label>Mật khẩu hiện tại</label>

            <input
                type="password"
                name="current_password"
                required>


            <label>Mật khẩu mới</label>

            <input
                type="password"
                name="password"
                required>


            <label>Xác nhận mật khẩu mới</label>

            <input
                type="password"
                name="password_confirmation"
                required>


            <button
                type="submit"
                class="btn">
                Cập nhật mật khẩu
            </button>

        </form>


        <a
            href="{{ route('profile.edit') }}"
            class="back">
            ← Quay lại thông tin cá nhân
        </a>

    </div>

</body>

</html>