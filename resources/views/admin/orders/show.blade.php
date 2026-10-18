@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')

<div class="admin-card">
    <div class="card-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 class="card-top-title">Chi tiết đơn hàng #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn-ad btn-ad-outline">
            ← Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo cập nhật thành công --}}
    @if (session('success'))
        <div style="padding: 12px; background-color: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Thông tin khách hàng --}}
    <div style="background: #fafafa; padding: 20px; border-radius: 6px; margin-bottom: 25px; border: 1px solid #eee;">
        <h3 style="font-size: 16px; margin-bottom: 12px; font-weight: 600;">Thông tin khách hàng</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; font-size: 14px;">
            <p><strong>Khách hàng:</strong> {{ $order->user->full_name ?? $order->receiver_name }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at }}</p>
            <p><strong>Tổng tiền:</strong> <strong style="color: #d9534f;">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</strong></p>
        </div>
    </div>

    {{-- Bảng danh sách sản phẩm trong đơn hàng --}}
    <h3 style="font-size: 16px; margin-bottom: 12px; font-weight: 600;">Sản phẩm trong đơn hàng</h3>
    <table class="admin-table" style="margin-bottom: 25px;">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th style="width: 100px; text-align: center;">Số lượng</th>
                <th style="width: 150px;">Đơn giá</th>
                <th style="width: 150px; text-align: right;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($order->details as $detail)
                <tr>
                    <td style="font-weight: 400;">
                        {{ $detail->product->name ?? 'Sản phẩm không tồn tại' }}
                    </td>
                    <td style="text-align: center;">{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                    <td style="text-align: right; font-weight: 500;">
                        {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--ad-muted); padding: 30px;">
                        Đơn hàng chưa có sản phẩm.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Cập nhật trạng thái --}}
    <div style="background: #fafafa; padding: 20px; border-radius: 6px; border: 1px solid #eee;">
        <h3 style="font-size: 16px; margin-bottom: 12px; font-weight: 600;">Cập nhật trạng thái đơn hàng</h3>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            @csrf
            @method('PUT')

           <select name="status" class="form-select">
    <option value="Chờ xử lý" {{ $order->status == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
    <option value="Đang xử lý" {{ $order->status == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
    <option value="Đang giao" {{ $order->status == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
    <option value="Hoàn thành" {{ $order->status == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
    <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
            </select>

            <button type="submit" class="btn-ad btn-ad-dark">
                Cập nhật trạng thái
            </button>
        </form>
    </div>
</div>

@endsection