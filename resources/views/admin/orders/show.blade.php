<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #333;
            color: white;
        }

        select,
        button {
            padding: 8px 12px;
            margin-top: 10px;
        }

        button {
            cursor: pointer;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>

        {{-- Thông báo cập nhật thành công --}}
        @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Thông tin khách hàng --}}
        <div class="info">
            <h2>Thông tin khách hàng</h2>

            <p>
                <strong>Khách hàng:</strong>
                {{ $order->user->full_name ?? $order->receiver_name }}
            </p>

            <p>
                <strong>Số điện thoại:</strong>
                {{ $order->phone }}
            </p>

            <p>
                <strong>Địa chỉ:</strong>
                {{ $order->address }}
            </p>

            <p>
                <strong>Ngày đặt:</strong>
                {{ $order->created_at }}
            </p>

            <p>
                <strong>Tổng tiền:</strong>
                {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
            </p>
        </div>

        {{-- Chi tiết sản phẩm --}}
        <h2>Sản phẩm trong đơn hàng</h2>

        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($order->details as $detail)
                <tr>
                    <td>
                        {{ $detail->product->name ?? 'Sản phẩm không tồn tại' }}
                    </td>

                    <td>
                        {{ $detail->quantity }}
                    </td>

                    <td>
                        {{ number_format($detail->price, 0, ',', '.') }} VNĐ
                    </td>

                    <td>
                        {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        Đơn hàng chưa có sản phẩm.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Cập nhật trạng thái --}}
        <h2>Cập nhật trạng thái đơn hàng</h2>

        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
            @csrf
            @method('PUT')

            <select name="status">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                    Chờ xử lý
                </option>

                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                    Đang xử lý
                </option>

                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                    Đang giao
                </option>

                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                    Hoàn thành
                </option>

                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                    Đã hủy
                </option>
            </select>

            <br>

            <button type="submit">
                Cập nhật trạng thái
            </button>
        </form>

        <br>

        <a href="{{ route('admin.orders.index') }}">
            ← Quay lại danh sách đơn hàng
        </a>

    </div>

</body>

</html>