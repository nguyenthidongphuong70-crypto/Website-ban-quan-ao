@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')

{{-- CSS RESPONSIVE DÀNH RIÊNG CHO ĐIỆN THOẠI (Máy tính giữ nguyên 100% đẹp mắt) --}}
<style>
    /* Hiệu ứng con trỏ chuột cho các ô Stats */
    .stat-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    /* CHỈ CHẠY TRÊN MÀN HÌNH ĐIỆN THOẠI (< 768px) */
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 12px !important;
        }
        .header-flex-box {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }
        .header-flex-box h2 {
            font-size: 18px !important;
        }
        .header-flex-box div {
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
        }
        .header-flex-box a {
            width: 100% !important;
            text-align: center !important;
        }
        .chart-vip-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

{{-- Bọc toàn bộ nội dung trong một khối có padding / margin an toàn --}}
<div class="dashboard-wrapper" style="padding: 20px 30px; background-color: #f8f9fa; min-height: 100vh;">

    {{-- Nút Xuất Báo Cáo --}}
    <div class="d-flex justify-content-between align-items-center mb-4 header-flex-box" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="font-size: 22px; font-weight: 600; color: #111; margin: 0;"> Tổng quan doanh thu & hệ thống</h2>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.export.excel') }}" class="btn-ad btn-ad-dark" style="padding: 10px 18px; font-size: 13px; text-decoration: none; background-color: #198754; color: white; border-radius: 6px;">
                 Xuất Excel Thống Kê
            </a>
            <a href="{{ route('admin.export.pdf') }}" target="_blank" class="btn-ad btn-ad-dark" style="padding: 10px 18px; font-size: 13px; text-decoration: none; background-color: #dc3545; color: white; border-radius: 6px;">
                 In Báo Cáo PDF
            </a>
        </div>
    </div>

    {{-- Thống kê dạng Card (Có đường dẫn click chuyển hướng linh hoạt) --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">

        {{-- Tổng sản phẩm -> Bấm vào sang trang danh sách sản phẩm --}}
        <a href="{{ route('admin.products.index') }}" class="stat-card-link">
            <div class="admin-card" style="margin: 0; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.05)';">
                <p style="color: #6c757d; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Tổng sản phẩm</p>
                <h2 style="font-size: 28px; font-weight: 600; color: #111; margin: 0;">{{ $totalProducts ?? 0 }}</h2>
            </div>
        </a>

        {{-- Tổng đơn hàng -> Bấm vào sang trang quản lý đơn hàng --}}
        <a href="{{ route('admin.orders.index') }}" class="stat-card-link">
            <div class="admin-card" style="margin: 0; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.05)';">
                <p style="color: #6c757d; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Tổng đơn hàng</p>
                <h2 style="font-size: 28px; font-weight: 600; color: #111; margin: 0;">{{ $totalOrders ?? 0 }}</h2>
            </div>
        </a>

        {{-- Đơn chờ xử lý -> Lọc danh sách đơn hàng trạng thái chờ --}}
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="stat-card-link">
            <div class="admin-card" style="margin: 0; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.05)';">
                <p style="color: #6c757d; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Đơn chờ xử lý</p>
                <h2 style="font-size: 28px; font-weight: 600; color: #ffc107; margin: 0;">{{ $pendingOrders ?? 0 }}</h2>
            </div>
        </a>

        {{-- Đơn hoàn thành -> Lọc danh sách đơn hàng hoàn thành --}}
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="stat-card-link">
            <div class="admin-card" style="margin: 0; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.05)';">
                <p style="color: #6c757d; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Đơn hoàn thành</p>
                <h2 style="font-size: 28px; font-weight: 600; color: #198754; margin: 0;">{{ $completedOrders ?? 0 }}</h2>
            </div>
        </a>

        {{-- Tổng doanh thu --}}
        <div class="admin-card" style="margin: 0; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border-left: 4px solid #198754;">
            <p style="color: #6c757d; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Tổng doanh thu</p>
            <h2 style="font-size: 22px; font-weight: 600; color: #198754; margin: 0;">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} VNĐ</h2>
        </div>

    </div>

    {{-- Khối Biểu đồ tăng trưởng & Khách hàng VIP --}}
    <div class="chart-vip-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px;">
        {{-- Biểu đồ doanh thu --}}
        <div class="admin-card" style="margin: 0; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #111;"> Biểu đồ tăng trưởng doanh thu</h3>
            <canvas id="revenueChart" height="110"></canvas>
        </div>

        {{-- Khách hàng VIP --}}
        <div class="admin-card" style="margin: 0; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: center; text-align: center;">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #111;"> Khách hàng "VIP"</h3>
            @if(isset($topCustomer) && $topCustomer)
                <div>
                    <h4 style="font-size: 18px; font-weight: 600; color: #0d6efd; margin-bottom: 5px;">{{ $topCustomer->full_name }}</h4>
                    <p style="color: #6c757d; font-size: 13px; margin-bottom: 10px;">{{ $topCustomer->email }}</p>
                    <span style="background: #e7f1ff; color: #0d6efd; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                        Đã mua: {{ $topCustomer->orders_count }} đơn hàng
                    </span>
                </div>
            @else
                <p style="color: #6c757d; font-size: 14px;">Chưa có dữ liệu khách hàng.</p>
            @endif
        </div>
    </div>

    {{-- Top sản phẩm bán chạy --}}
    <div class="admin-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #111;"> Top Sản Phẩm Bán Chạy Nhất</h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; color: #666;">
                        <th style="padding: 10px;">#</th>
                        <th style="padding: 10px;">Tên sản phẩm</th>
                        <th style="padding: 10px;">Tổng số lượng đã bán</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts ?? [] as $index => $item)
                        <tr style="border-bottom: 1px solid #f2f2f2;">
                            <td style="padding: 10px;">{{ $index + 1 }}</td>
                            <td style="padding: 10px; font-weight: 500; color: #111;">{{ $item->name }}</td>
                            <td style="padding: 10px;"><span style="background: #e7f1ff; color: #0d6efd; padding: 3px 8px; border-radius: 4px; font-weight: 500;">{{ $item->total_sold }} cái</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 15px; text-align: center; color: #6c757d;">Chưa có thống kê sản phẩm bán ra.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Khối chức năng quản lý điều hướng dưới đáy trang --}}
    <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 20px;">
        <a href="{{ route('admin.orders.index') }}" class="btn-ad btn-ad-dark" style="padding: 12px 24px; font-size: 14px; text-decoration: none; background: #212529; color: #fff; border-radius: 6px;">
             Quản lý đơn hàng
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn-ad btn-ad-outline" style="padding: 12px 24px; font-size: 14px; text-decoration: none; background: #fff; color: #212529; border: 1px solid #ced4da; border-radius: 6px;">
             Quản lý danh mục
        </a>
    </div>

</div>

{{-- Thư viện vẽ biểu đồ Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueByDate->pluck('date')) !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! json_encode($revenueByDate->pluck('revenue')) !!},
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection