@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container" style="max-width: 800px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: #28a745;">Đặt hàng thành công!</h2>
        <p style="color: #666;">Cảm ơn bạn đã mua hàng. Dưới đây là thông tin chi tiết đơn hàng của bạn:</p>
    </div>

    <div style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
        <h4>Thông tin nhận hàng</h4>
        <p><strong>Họ tên:</strong> {{ $order->receiver_name }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
        <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ strtoupper($order->payment_method) }}</p>
        <p><strong>Trạng thái đơn hàng:</strong> <span style="color: orange; font-weight: bold;">{{ ucfirst($order->status) }}</span></p>
    </div>

    <div>
        <h4>Danh sách sản phẩm đã mua</h4>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 10px; border-bottom: 1px solid #ddd;">Sản phẩm</th>
                    <th style="padding: 10px; border-bottom: 1px solid #ddd;">Số lượng</th>
                    <th style="padding: 10px; border-bottom: 1px solid #ddd;">Giá</th>
                    <th style="padding: 10px; border-bottom: 1px solid #ddd; text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $detail)
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $detail->product->name ?? 'Sản phẩm' }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $detail->quantity }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ number_format($detail->price) }} đ</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right;">{{ number_format($detail->price * $detail->quantity) }} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 20px;">
            <h3>Tổng thanh toán: <span style="color: #d9534f;">{{ number_format($order->total_price) }} đ</span></h3>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ url('/') }}" class="btn" style="background: #000; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">TIẾP TỤC MUA SẮM</a>
    </div>
</div>
@endsection