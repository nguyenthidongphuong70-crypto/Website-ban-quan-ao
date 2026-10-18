@extends('admin.layout')

@section('title', 'Báo cáo doanh thu hệ thống')

@section('content')

<style>
    @media print {
        header, nav, .admin-nav, .no-print, footer, .sidebar {
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
            margin: 0 !important;
            background: transparent !important;
        }
    }
</style>

<div class="admin-card">
    <div class="no-print" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h2 class="card-top-title" style="margin: 0;">Báo Cáo Doanh Thu & Hệ Thống</h2>
        <div>
            <button onclick="window.print()" class="btn-ad" style="cursor: pointer;">
                🖨️ Lưu thành PDF / In Báo Cáo
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn-ad btn-ad-outline" style="margin-left: 10px; text-decoration: none;">
                ← Quay lại Dashboard
            </a>
        </div>
    </div>

    <div style="border-bottom: 2px solid #111; padding-bottom: 15px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h2 style="margin: 0 0 5px 0; font-size: 22px; letter-spacing: 2px;">AUREN FASHION STORE</h2>
            <p style="margin: 0; color: var(--ad-muted); font-size: 13px;">Hệ thống Quản trị Thời trang Cao cấp</p>
        </div>
        <div style="text-align: right; font-size: 13px;">
            <p style="margin: 0 0 4px 0;"><strong>Ngày xuất:</strong> {{ date('d/m/Y H:i') }}</p>
            <p style="margin: 0;"><strong>Người lập:</strong> Quản trị viên (Admin)</p>
        </div>
    </div>

    <h3 style="margin-bottom: 10px; font-size: 15px; text-transform: uppercase;">📊 Tổng quan chỉ số hệ thống</h3>
    <table class="admin-table" style="margin-bottom: 25px;">
        <tr>
            <th style="width: 40%;">Tổng sản phẩm kho</th>
            <td>{{ number_format($totalProducts) }} sản phẩm</td>
        </tr>
        <tr>
            <th>Tổng đơn hàng toàn hệ thống</th>
            <td>{{ number_format($totalOrders) }} đơn</td>
        </tr>
        <tr>
            <th>Đơn hàng hoàn thành</th>
            <td>{{ number_format($completedOrders) }} đơn</td>
        </tr>
        <tr>
            <th><strong>Tổng doanh thu thực tế</strong></th>
            <td><strong style="color: #b91c1c; font-size: 16px;">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</strong></td>
        </tr>
    </table>

    <h3 style="margin-bottom: 10px; font-size: 15px; text-transform: uppercase;">📋 Chi tiết danh sách đơn hàng gần đây</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Mã Đơn</th>
                <th>Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Thời Gian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $orderItem)
            <tr>
                <td>#{{ $orderItem->id }}</td>
                <td>{{ $orderItem->user->full_name ?? 'Khách vãng lai' }}</td>
                <td>{{ number_format($orderItem->total_price, 0, ',', '.') }} VNĐ</td>
                <td><span class="badge-ad neutral">{{ ucfirst($orderItem->status) }}</span></td>
                <td>{{ $orderItem->created_at ? $orderItem->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection