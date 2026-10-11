@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container py-5 text-center">
    <div class="card border-0 shadow-sm p-5 mx-auto" style="max-width: 600px;">
        <div class="mb-4 text-success fs-1">✔</div>
        <h2 class="fw-bold mb-3">Đặt hàng thành công!</h2>
        <p class="text-muted mb-4">Cảm ơn bạn đã mua hàng. Mã đơn hàng của bạn là: <strong>#{{ $order->id }}</strong></p>
        
        <div class="text-start border-top pt-3 mb-4">
            <p><strong>Người nhận:</strong> {{ $order->name }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($order->total_price) }} đ</span></p>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark py-2">Tiếp tục mua sắm</a>
            <!-- Nếu bạn sau này có trang lịch sử đơn hàng -->
            <a href="#" class="btn btn-dark py-2">Xem lịch sử đơn hàng</a>
        </div>
    </div>
</div>
@endsection