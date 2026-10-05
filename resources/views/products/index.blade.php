<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sản phẩm - AUREN</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #222;
            background: #fff;
        }

        /* ================= NAVBAR ================= */

        .navbar {
            height: 72px;
            padding: 0 55px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            border-bottom: 1px solid #eee;

            background: white;
        }

        .logo {
            font-family: Georgia, serif;
            font-size: 27px;
            letter-spacing: 3px;
            text-decoration: none;
            color: #111;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links > a {
            text-decoration: none;
            color: #333;
            font-size: 13px;
        }

        .nav-links > a:hover {
            color: #9a704d;
        }

        /* ================= ACCOUNT ================= */

        .account-menu {
            position: relative;
        }

        .account-title {
            display: flex;
            align-items: center;
            gap: 7px;

            padding: 25px 5px;

            font-size: 13px;
            cursor: pointer;
        }

        .account-title i {
            font-size: 18px;
        }

        .account-dropdown {
            display: none;

            position: absolute;
            top: 100%;
            right: 0;

            width: 180px;

            background: white;

            border: 1px solid #eee;

            box-shadow: 0 8px 25px rgba(0, 0, 0, .12);

            z-index: 999;

            padding: 7px 0;
        }

        .account-menu:hover .account-dropdown {
            display: block;
        }

        .account-dropdown a,
        .account-dropdown button {
            width: 100%;

            display: block;

            padding: 12px 18px;

            border: none;
            background: white;

            text-align: left;

            text-decoration: none;

            color: #222;

            font-size: 13px;

            cursor: pointer;
        }

        .account-dropdown a:hover,
        .account-dropdown button:hover {
            background: #f5f2ee;
        }

        .account-dropdown form {
            margin: 0;
        }

        /* ================= MAIN ================= */

        .container {
            width: 92%;
            max-width: 1250px;
            margin: 35px auto;
        }

        .page-title {
            font-family: Georgia, serif;
            font-size: 34px;
            font-weight: normal;
            margin-bottom: 25px;
        }

        /* ================= SEARCH ================= */

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 35px;
        }

        .search-form input,
        .search-form select {
            height: 42px;

            border: 1px solid #ddd;

            border-radius: 5px;

            padding: 0 12px;

            outline: none;
        }

        .search-form input {
            width: 280px;
        }

        .search-form select {
            width: 180px;
        }

        .search-form button {
            height: 42px;

            padding: 0 25px;

            border: none;

            background: #1c1b18;

            color: white;

            border-radius: 5px;

            cursor: pointer;
        }

        /* ================= PRODUCTS ================= */

        .product-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 30px;
        }

        .product-card {
            border: 1px solid #eee;
            background: white;

            padding-bottom: 20px;

            transition: .2s;
        }

        .product-card:hover {
            box-shadow:
                0 10px 30px rgba(0, 0, 0, .08);

            transform: translateY(-3px);
        }

        .product-image {
            width: 100%;
            height: 330px;

            object-fit: cover;

            background: #f5f5f5;
        }

        .product-info {
            padding: 18px;
        }

        .product-name {
            margin-bottom: 12px;
        }

        .product-name a {
            font-family: Georgia, serif;

            font-size: 20px;

            color: #222;

            text-decoration: none;
        }

        .product-name a:hover {
            text-decoration: underline;
        }

        .product-info p {
            font-size: 13px;

            margin-bottom: 8px;

            color: #666;
        }

        .price {
            color: #111 !important;
            font-weight: bold;
            font-size: 15px !important;
        }

        .empty {
            padding: 30px 0;
        }

        .pagination {
            margin-top: 35px;
        }

        @media(max-width: 900px) {

            .navbar {
                padding: 0 20px;
            }

            .nav-links > a {
                display: none;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 600px) {

            .product-grid {
                grid-template-columns: 1fr;
            }

            .search-form {
                flex-direction: column;
            }

            .search-form input,
            .search-form select,
            .search-form button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->

<header class="navbar">

    <a href="/" class="logo">
        AUREN
    </a>


    <nav class="nav-links">

        <a href="/">
            Trang chủ
        </a>

        <a href="{{ route('products.index') }}">
            Sản phẩm
        </a>

        <a href="#">
            Bộ sưu tập
        </a>


        <!-- TÀI KHOẢN -->

        <div class="account-menu">

            <div class="account-title">

                <i class="fa-regular fa-circle-user"></i>

                <span>
                    Tài khoản
                </span>

                <i class="fa-solid fa-chevron-down"
                   style="font-size: 9px;">
                </i>

            </div>


            <div class="account-dropdown">

                <!-- CHƯA ĐĂNG NHẬP -->

                @guest

                    <a href="{{ route('login') }}">

                        <i class="fa-solid fa-right-to-bracket"></i>
                        &nbsp; Đăng nhập

                    </a>


                    <a href="{{ route('register') }}">

                        <i class="fa-regular fa-user"></i>
                        &nbsp; Đăng ký

                    </a>

                @endguest


                <!-- ĐÃ ĐĂNG NHẬP -->

                @auth

                    <a href="{{ route('profile.edit') }}">

                        <i class="fa-regular fa-user"></i>
                        &nbsp; Thông tin cá nhân

                    </a>


                    <form
                        action="{{ route('logout') }}"
                        method="POST">

                        @csrf


                        <button type="submit">

                            <i class="fa-solid fa-arrow-right-from-bracket"></i>

                            &nbsp; Đăng xuất

                        </button>

                    </form>

                @endauth

            </div>

        </div>

    </nav>

</header>


<!-- ================= CONTENT ================= -->

<main class="container">

    <h1 class="page-title">
        Danh sách sản phẩm
    </h1>


    <!-- TÌM KIẾM -->

    <form
        method="GET"
        action="{{ route('products.index') }}"
        class="search-form">

        <input
            type="text"
            name="search"
            placeholder="Tìm sản phẩm..."
            value="{{ request('search') }}">


        <select name="category">

            <option value="">
                Tất cả danh mục
            </option>


            @foreach ($categories as $category)

                <option
                    value="{{ $category->id }}"
                    @selected(request('category') == $category->id)>

                    {{ $category->name }}

                </option>

            @endforeach

        </select>


        <button type="submit">

            <i class="fa-solid fa-magnifying-glass"></i>

            Tìm kiếm

        </button>

    </form>


    <!-- DANH SÁCH SẢN PHẨM -->

    <div class="product-grid">

        @forelse ($products as $product)

            <div class="product-card">


                @if ($product->image)

                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="product-image">

                @endif


                <div class="product-info">


                    <h2 class="product-name">

                        <a href="{{ route('products.show', $product) }}">

                            {{ $product->name }}

                        </a>

                    </h2>


                    <p>

                        Danh mục:
                        {{ $product->category?->name }}

                    </p>


                    <p class="price">

                        {{ number_format($product->price, 0, ',', '.') }}
                        VNĐ

                    </p>


                    <p>

                        Còn lại:
                        {{ $product->stock }}

                    </p>


                </div>

            </div>


        @empty

            <p class="empty">
                Chưa có sản phẩm nào.
            </p>

        @endforelse

    </div>


    <div class="pagination">

        {{ $products->links() }}

    </div>

</main>


</body>
</html>