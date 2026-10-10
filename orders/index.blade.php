@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Lịch sử đơn hàng của bạn</h2>

    @if(isset($orders) && $orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Người nhận</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->name }}</td>
                            <td class="text-danger fw-bold">{{ number_format($order->total_price) }} đ</td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
            <a href="{{ route('products.index') }}" class="btn btn-dark">Mua sắm ngay</a>
        </div>
    @endif
</div>
@endsection