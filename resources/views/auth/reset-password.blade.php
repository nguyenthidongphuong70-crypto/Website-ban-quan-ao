<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Đặt mật khẩu mới - AUREN</title>

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
            width: 420px;
            max-width: calc(100% - 30px);

            padding: 45px 40px;

            background: white;

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
            text-align: center;

            font-family: 'Cormorant Garamond', serif;

            font-size: 31px;

            font-weight: 400;

            margin-bottom: 25px;
        }

        label {
            display: block;

            font-size: 12px;

            margin: 15px 0 7px;
        }

        input {
            width: 100%;

            height: 48px;

            border: 1px solid #ddd6ce;

            padding: 0 14px;

            outline: none;
        }

        input:focus {
            border-color: #111;
        }

        .btn {
            width: 100%;

            height: 48px;

            border: none;

            margin-top: 25px;

            background: #111;

            color: white;

            cursor: pointer;

            font-size: 12px;

            letter-spacing: 2px;

            text-transform: uppercase;
        }

        .message {
            padding: 10px 12px;

            margin-bottom: 15px;

            background: #f3f8f3;

            color: #29602e;

            font-size: 12px;
        }

        .error {
            padding: 10px 12px;

            margin-bottom: 15px;

            background: #fff1f1;

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


    <h1>
        Đặt mật khẩu mới
    </h1>


    @if(session('success'))

        <div class="message">
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
        action="{{ route('password.reset.phone') }}"
        method="POST"
    >

        @csrf


        <label>
            Mật khẩu mới
        </label>

        <input
            type="password"
            name="password"
            placeholder="Ít nhất 6 ký tự"
            required
        >


        <label>
            Xác nhận mật khẩu
        </label>

        <input
            type="password"
            name="password_confirmation"
            placeholder="Nhập lại mật khẩu"
            required
        >


        <button
            class="btn"
            type="submit"
        >
            Đổi mật khẩu
        </button>

    </form>

</div>

</body>
</html>