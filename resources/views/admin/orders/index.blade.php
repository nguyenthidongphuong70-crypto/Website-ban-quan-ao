@extends('admin.layout')

@section('title', 'Quản lý đơn hàng')

@section('content')

<div class="admin-card">
    <div class="card-top">
        <h2 class="card-top-title">Danh sách đơn hàng</h2>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.orders.index') }}"
          style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
        <input
            type="text"
            name="search"
            class="form-input"
            placeholder="Tìm kiếm đơn hàng..."
            value="{{ request('search') }}"
            style="max-width:280px;"
        >
        <button type="submit" class="btn-ad btn-ad-outline">Tìm kiếm</button>
        @if(request('search'))
            <a href="{{ route('admin.orders.index') }}" class="btn-ad btn-ad-outline">Đặt lại</a>
        @endif
    </form>

    {{-- Table --}}
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:70px;">ID</th>
                <th>Khách hàng</th>
                <th style="width:180px;">Tổng tiền</th>
                <th style="width:150px;">Trạng thái</th>
                <th style="width:180px;">Ngày đặt</th>
                <th style="width:240px; text-align:right;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td style="color:var(--ad-muted); font-size:12px;">#{{ $order->id }}</td>
                    <td style="font-weight:400;">{{ $order->user->full_name ?? $order->receiver_name }}</td>
                    <td>
                        <span class="badge-ad neutral">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                    </td>
                    <td style="font-weight:400;" class="status">{{ $order->status }}</td>
                    <td style="color:var(--ad-muted); font-size:12px;">{{ $order->created_at }}</td>
                    <td style="text-align:right; white-space:nowrap;">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-ad btn-ad-outline" style="margin-right:4px;">
                            Xem chi tiết
                        </a>
                        <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn-ad">
                            🖨️ In hóa đơn
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--ad-muted); padding:40px;">
                        Chưa có đơn hàng nào.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($orders, 'links'))
        <div class="pagination-wrap">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection