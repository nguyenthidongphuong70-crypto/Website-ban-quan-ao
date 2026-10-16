@extends('layouts.app')
@section('title', 'Các Đơn Hàng Đã Đặt')
@section('content')
<div class="container" style="max-width: 900px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="margin-bottom: 20px; text-transform: uppercase; font-size: 22px;">📦 Lịch sử đơn hàng của bạn</h2>

    @if($orders->isEmpty())
        <p style="color: #666;">Bạn chưa có đơn hàng nào.</p>
        <a href="{{ route('home') }}" class="btn" style="display: inline-block; margin-top: 15px; background: #000; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">MUA SẮM NGAY</a>
    @else
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Mã đơn</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Người nhận</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Tổng tiền</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Thanh toán</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Trạng thái</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd; text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $item)
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold;">#{{ $item->id }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight:bold   ">{{ $item->receiver_name }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; color: #020202; font-weight: bold;">{{ number_format($item->total_price) }} đ</td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; text-transform: uppercase;">{{ $item->payment_method }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; background: {{ $item->status == 'paid' ? '#d4edda' : '#fff3cd' }}; color: {{ $item->status == 'paid' ? '#155724' : '#856404' }};">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                        <a href="{{ route('order.success', $item->id) }}" style="background: #000; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px;">Xem chi tiết</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection