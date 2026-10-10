@extends('admin.layout')

@section('title', 'Hóa đơn #' . $order->id)

@section('content')

{{-- CSS tùy chỉnh riêng khi bấm nút Ctrl + P / In ấn để tự động ẩn Header/Sidebar admin và chỉ in khung hóa đơn --}}
<style>
    @media print {
        /* Ẩn thanh header, navbar và các nút không liên quan khi in */
        header, nav, .admin-nav, .no-print, footer {
            display: none !important;
        }
        body {
            background-color: #fff !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .admin-card {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
        }
    }
</style>

<div class="admin-card">
    {{-- Thanh Tiêu Đề Top --}}
    <div class="card-top" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; border-bottom:1px solid var(--ad-border, #e5e7eb); padding-bottom:15px;">
        <div>
            <h2 class="card-top-title" style="margin:0; font-size:24px; letter-spacing:2px; text-transform:uppercase;">Hóa Đơn Bán Hàng #{{ $order->id }}</h2>
            <span style="color:var(--ad-muted, #6b7280); font-size:13px;">Ngày đặt: {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : date('d/m/Y H:i') }}</span>
        </div>
        <div class="no-print" style="display:flex; gap:10px;">
            <button onclick="window.print()" class="btn-ad">
                🖨️ In hóa đơn trực tiếp
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn-ad btn-ad-outline">
                ← Quay lại danh sách
            </a>
        </div>
    </div>

    {{-- Khối thông tin khách hàng & Giao hàng --}}
    <div style="background-color:var(--ad-bg-light, #f9fafb); border:1px solid var(--ad-border, #e5e7eb); border-radius:6px; padding:20px; margin-bottom:25px;">
        <h4 style="margin-top:0; margin-bottom:12px; font-size:15px; text-transform:uppercase; letter-spacing:1px; color:var(--ad-heading, #111827);">
            Thông tin khách hàng & Giao hàng
        </h4>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:12px; font-size:14px;">
            <div>
                <strong style="color:var(--ad-muted, #6b7280);">Người nhận:</strong>
                <p style="margin:3px 0 0 0; font-weight:500;">{{ $order->receiver_name ?? ($order->user->full_name ?? ($order->user->name ?? 'Khách vãng lai')) }}</p>
            </div>
            <div>
                <strong style="color:var(--ad-muted, #6b7280);">Số điện thoại:</strong>
                <p style="margin:3px 0 0 0; font-weight:500;">{{ $order->phone ?? ($order->user->phone ?? 'N/A') }}</p>
            </div>
            <div>
                <strong style="color:var(--ad-muted, #6b7280);">Địa chỉ giao hàng:</strong>
                <p style="margin:3px 0 0 0; font-weight:500;">{{ $order->address ?? 'Nhận tại cửa hàng' }}</p>
            </div>
            <div>
                <strong style="color:var(--ad-muted, #6b7280);">Trạng thái đơn:</strong>
                <p style="margin:3px 0 0 0;">
                    <span class="badge-ad neutral" style="text-transform:uppercase; font-weight:600;">{{ $order->status }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Bảng danh sách chi tiết sản phẩm --}}
    <h4 style="margin-bottom:15px; font-size:15px; text-transform:uppercase; letter-spacing:1px;">Chi tiết sản phẩm</h4>
    <table class="admin-table" style="width:100%; margin-bottom:25px;">
        <thead>
            <tr>
                <th style="width:60px; text-align:center;">STT</th>
                <th>Sản phẩm</th>
                <th style="width:100px; text-align:center;">Số lượng</th>
                <th style="width:150px; text-align:right;">Đơn giá</th>
                <th style="width:180px; text-align:right;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($order->details) && $order->details->count() > 0)
                @foreach($order->details as $index => $item)
                    <tr>
                        <td style="text-align:center; color:var(--ad-muted); font-size:13px;">{{ $index + 1 }}</td>
                        <td style="font-weight:500;">{{ $item->product->name ?? 'Sản phẩm AUREN' }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right;">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                        <td style="text-align:right; font-weight:500;">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="text-align:center; color:var(--ad-muted); font-size:13px;">1</td>
                    <td style="font-weight:500;">Sản phẩm thời trang AUREN (Đơn hàng #{{ $order->id }})</td>
                    <td style="text-align:center;">1</td>
                    <td style="text-align:right;">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                    <td style="text-align:right; font-weight:500;">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Khối tổng tiền --}}
    <div style="text-align:right; border-top:1px solid var(--ad-border, #e5e7eb); padding-top:15px;">
        <span style="font-size:15px; text-transform:uppercase; letter-spacing:1px; color:var(--ad-muted, #6b7280);">Tổng thanh toán:</span>
        <span style="font-size:22px; font-weight:700; margin-left:10px; color:var(--ad-heading, #111827);">
            {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
        </span>
    </div>
</div>

@endsection