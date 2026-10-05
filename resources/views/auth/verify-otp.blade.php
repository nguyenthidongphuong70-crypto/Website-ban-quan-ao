<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Xác nhận OTP - AUREN</title>

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
            justify-content: center;
            align-items: center;

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
            margin: 0 0 10px;

            text-align: center;

            font-family: 'Cormorant Garamond', serif;

            font-size: 31px;

            font-weight: 400;
        }

        .subtitle {
            text-align: center;

            color: #777;

            font-size: 13px;

            margin-bottom: 25px;
        }

        .otp {
            width: 100%;
            height: 55px;

            border: 1px solid #ddd6ce;

            text-align: center;

            font-size: 24px;

            letter-spacing: 10px;

            outline: none;
        }

        .otp:focus {
            border-color: #111;
        }

        .btn {
            width: 100%;
            height: 48px;

            border: none;

            background: #111;
            color: white;

            margin-top: 20px;

            cursor: pointer;

            text-transform: uppercase;

            letter-spacing: 2px;

            font-size: 12px;
        }

        .message {
            background: #f3f8f3;

            padding: 10px 12px;

            color: #29602e;

            font-size: 12px;

            margin-bottom: 15px;
        }

        .error {
            background: #fff1f1;

            padding: 10px 12px;

            color: #a12626;

            font-size: 12px;

            margin-bottom: 15px;
        }

        .demo {
            background: #f4f1eb;

            border: 1px dashed #aaa;

            padding: 13px;

            margin-bottom: 18px;

            text-align: center;

            font-size: 13px;
        }

        .demo strong {
            font-size: 20px;

            letter-spacing: 5px;
        }

        .back {
            display: block;

            margin-top: 20px;

            text-align: center;

            font-size: 12px;

            color: #555;

            text-decoration: none;
        }

    </style>

</head>

<body>

<div class="box">

    <div class="brand">
        ♤ AUREN
    </div>


    <h1>Xác nhận OTP</h1>

    <p class="subtitle">
        Nhập mã OTP gồm 6 chữ số.
        Mã có hiệu lực trong 5 phút.
    </p>


    @if(session('success'))

        <div class="message">
            {{ session('success') }}
        </div>

    @endif


    {{-- CHỈ HIỆN KHI CHẠY LOCAL --}}
    @if(session('demo_otp'))

        <div class="demo">

            OTP demo của bạn:

            <br>

            <strong>
                {{ session('demo_otp') }}
            </strong>

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
        action="{{ route('password.otp.verify') }}"
        method="POST"
    >

        @csrf

        <input
            class="otp"
            type="text"
            name="otp"
            maxlength="6"
            inputmode="numeric"
            autocomplete="one-time-code"
            placeholder="000000"
            required
            autofocus
        >

        <button
            type="submit"
            class="btn"
        >
            Xác nhận OTP
        </button>

    </form>


    <a
        href="{{ route('password.request') }}"
        class="back"
    >
        ← Gửi lại mã OTP
    </a>

</div>

</body>
</html>