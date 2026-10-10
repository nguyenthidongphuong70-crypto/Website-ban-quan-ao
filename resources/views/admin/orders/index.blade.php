<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #333;
            color: white;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        .status {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>Quản lý đơn hàng</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày đặt</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>

                    <td>
                        {{ $order->user->full_name ?? $order->receiver_name }}
                    </td>

                    <td>
                        {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                    </td>

                    <td class="status">
                        {{ $order->status }}
                    </td>

                    <td>
                        {{ $order->created_at }}
                    </td>

                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        Chưa có đơn hàng nào.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>