<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Quên mật khẩu - AUREN</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

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
            color: #222;

            font-family: 'DM Sans', sans-serif;
        }

        .box {
            width: 420px;
            max-width: calc(100% - 30px);

            background: white;

            padding: 45px 40px;

            border: 1px solid #e8e0d6;

            box-shadow: 0 15px 45px rgba(0,0,0,.06);
        }

        .brand {
            text-align: center;

            font-family: 'Cormorant Garamond', serif;
            font-size: 27px;

            letter-spacing: 7px;

            margin-bottom: 35px;
        }

        h1 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 400;

            font-size: 31px;

            text-align: center;

            margin: 0 0 10px;
        }

        .subtitle {
            font-size: 13px;
            color: #777;

            text-align: center;

            margin-bottom: 30px;
        }

        label {
            display: block;

            font-size: 12px;

            margin-bottom: 7px;
        }

        input {
            width: 100%;
            height: 48px;

            border: 1px solid #ddd6ce;

            padding: 0 14px;

            outline: none;

            font-family: inherit;
        }

        input:focus {
            border-color: #222;
        }

        .btn {
            width: 100%;
            height: 48px;

            border: 0;

            background: #111;
            color: white;

            margin-top: 22px;

            cursor: pointer;

            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .back {
            display: block;

            margin-top: 22px;

            text-align: center;

            color: #555;

            font-size: 12px;

            text-decoration: none;
        }

        .error {
            padding: 10px 12px;

            margin-bottom: 18px;

            background: #fff2f2;

            color: #a12626;

            font-size: 12px;
        }

    </style>

</head>

<body>

<div class="box">

    <div class="brand">
        ♤ AUREN
    </div>

    <h1>Quên mật khẩu</h1>

    <p class="subtitle">
        Nhập số điện thoại đã đăng ký để nhận mã OTP.
    </p>


    @if($errors->any())

        <div class="error">

            @foreach($errors->all() as $error)

                <div>{{ $error }}</div>

            @endforeach

        </div>

    @endif


    <form action="{{ route('password.otp.send') }}"
          method="POST">

        @csrf

        <label>
            Số điện thoại
        </label>

        <input
            type="text"
            name="phone"
            value="{{ old('phone') }}"
            placeholder="Ví dụ: 0901234567"
            required
            autofocus
        >

        <button
            type="submit"
            class="btn"
        >
            Gửi mã OTP
        </button>

    </form>


    <a
        href="{{ route('login') }}"
        class="back"
    >
        ← Quay lại đăng nhập
    </a>

</div>

</body>
</html>