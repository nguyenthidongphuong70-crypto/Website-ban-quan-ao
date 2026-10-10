@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Thống kê dạng Card --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <div class="admin-card" style="margin: 0;">
        <p style="color: var(--ad-muted); font-size: 14px; font-weight: 500; margin-bottom: 8px;">Tổng sản phẩm</p>
        <h2 style="font-size: 28px; font-weight: 600; color: #111;">{{ $totalProducts ?? 0 }}</h2>
    </div>

    <div class="admin-card" style="margin: 0;">
        <p style="color: var(--ad-muted); font-size: 14px; font-weight: 500; margin-bottom: 8px;">Tổng đơn hàng</p>
        <h2 style="font-size: 28px; font-weight: 600; color: #111;">{{ $totalOrders ?? 0 }}</h2>
    </div>

    <div class="admin-card" style="margin: 0;">
        <p style="color: var(--ad-muted); font-size: 14px; font-weight: 500; margin-bottom: 8px;">Đơn chờ xử lý</p>
        <h2 style="font-size: 28px; font-weight: 600; color: #111;">{{ $pendingOrders ?? 0 }}</h2>
    </div>

    <div class="admin-card" style="margin: 0;">
        <p style="color: var(--ad-muted); font-size: 14px; font-weight: 500; margin-bottom: 8px;">Đơn hoàn thành</p>
        <h2 style="font-size: 28px; font-weight: 600; color: #111;">{{ $completedOrders ?? 0 }}</h2>
    </div>

    <div class="admin-card" style="margin: 0;">
        <p style="color: var(--ad-muted); font-size: 14px; font-weight: 500; margin-bottom: 8px;">Tổng doanh thu</p>
        <h2 style="font-size: 28px; font-weight: 600; color: #111;">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} VNĐ</h2>
    </div>

</div>

{{-- Khối chức năng quản lý --}}
<div class="admin-card">
    <div class="card-top" style="margin-bottom: 20px;">
        <h2 class="card-top-title">Quản lý hệ thống</h2>
    </div>

    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="{{ route('admin.orders.index') }}" class="btn-ad btn-ad-dark" style="padding: 12px 24px; font-size: 14px;">
            📦 Quản lý đơn hàng
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn-ad btn-ad-outline" style="padding: 12px 24px; font-size: 14px;">
            📁 Quản lý danh mục
        </a>
    </div>
</div>

@endsection