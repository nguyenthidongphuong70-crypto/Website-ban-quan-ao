<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
        }

        .header {
            background: #111827;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
        }

        .container {
            padding: 30px 40px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            color: #6b7280;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .card .number {
            font-size: 30px;
            font-weight: bold;
            color: #111827;
        }

        .menu {
            margin-top: 30px;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .menu h2 {
            margin-bottom: 20px;
        }

        .menu a {
            display: inline-block;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 10px;
        }

        .menu a:hover {
            background: #1d4ed8;
        }

        .logout {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Trang quản trị</h1>

        <div>
            Xin chào, Admin
        </div>
    </div>

    <div class="container">

        <div class="cards">

            <div class="card">
                <h3>Tổng sản phẩm</h3>
                <div class="number">
                    {{ $totalProducts }}
                </div>
            </div>

            <div class="card">
                <h3>Tổng đơn hàng</h3>
                <div class="number">
                    {{ $totalOrders }}
                </div>
            </div>

            <div class="card">
                <h3>Đơn chờ xử lý</h3>
                <div class="number">
                    {{ $pendingOrders }}
                </div>
            </div>

            <div class="card">
                <h3>Đơn hoàn thành</h3>
                <div class="number">
                    {{ $completedOrders }}
                </div>
            </div>

            <div class="card">
                <h3>Tổng doanh thu</h3>
                <div class="number">
                    {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ
                </div>
            </div>

        </div>

        <div class="menu">

            <h2>Quản lý</h2>

            <a href="{{ route('admin.orders.index') }}">
                Quản lý đơn hàng
            </a>

        </div>

    </div>

</body>

</html>