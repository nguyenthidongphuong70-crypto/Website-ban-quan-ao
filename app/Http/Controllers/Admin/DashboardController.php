<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng số sản phẩm
        $totalProducts = Product::count();

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Đơn hàng đang chờ xử lý
        $pendingOrders = Order::where('status', 'pending')->count();

        // Đơn hoàn thành
        $completedOrders = Order::count();

        // Tổng doanh thu tính từ TẤT CẢ đơn hàng
        $totalRevenue = Order::sum('total_price');

        // Top sản phẩm bán chạy nhất (ĐÃ ĐỔI THÀNH order_details)
        $topProducts = [];
        try {
            $topProducts = DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(order_details.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            $topProducts = [];
        }

        // Khách hàng mua nhiều đơn hàng nhất (VIP)
        $topCustomer = null;
        try {
            $topCustomer = User::withCount('orders')
                ->orderByDesc('orders_count')
                ->first();
        } catch (\Exception $e) {
            $topCustomer = null;
        }

        // Doanh thu theo ngày (Cho biểu đồ) - Lấy tất cả đơn hàng
        $revenueByDate = collect();
        try {
            $revenueByDate = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as revenue'))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->limit(7)
                ->get();
        } catch (\Exception $e) {
            $revenueByDate = collect();
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'topProducts',
            'topCustomer',
            'revenueByDate'
        ));
    }

    // Xuất file Excel báo cáo doanh thu & thống kê
    public function exportExcel()
    {
        $fileName = 'Bao-Cao-Doanh-Thu-' . date('Y-m-d') . '.xls';
        
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $orders = Order::with('user')->latest()->get();

        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head><meta charset="UTF-8"></head>
        <body>
            <h2>BÁO CÁO TỔNG QUAN HỆ THỐNG AUREN</h2>
            <p>Ngày xuất báo cáo: ' . date('d/m/Y H:i:s') . '</p>
            <table border="1">
                <tr>
                    <th style="background-color: #f2f2f2;">Tổng Sản Phẩm</th>
                    <th style="background-color: #f2f2f2;">Tổng Đơn Hàng</th>
                    <th style="background-color: #f2f2f2;">Tổng Doanh Thu (VNĐ)</th>
                </tr>
                <tr>
                    <td>' . $totalProducts . '</td>
                    <td>' . $totalOrders . '</td>
                    <td>' . number_format($totalRevenue, 0, ',', '.') . ' VNĐ</td>
                </tr>
            </table>
            <br>
            <h3>DANH SÁCH ĐƠN HÀNG CHI TIẾT</h3>
            <table border="1">
                <thead>
                    <tr style="background-color: #333; color: white;">
                        <th>Mã Đơn</th>
                        <th>Khách Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Đặt</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($orders as $order) {
            $html .= '<tr>
                <td># ' . $order->id . '</td>
                <td>' . ($order->user->full_name ?? 'Khách vãng lai') . '</td>
                <td>' . number_format($order->total_price, 0, ',', '.') . ' VNĐ</td>
                <td>' . $order->status . '</td>
                <td>' . $order->created_at . '</td>
            </tr>';
        }

        $html .= '</tbody></table></body></html>';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    // Xuất trang báo cáo PDF/In ấn
    public function exportPdf()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $completedOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $orders = Order::with('user')->latest()->get();

        return view('admin.reports.pdf', compact(
            'totalProducts', 
            'totalOrders', 
            'completedOrders', 
            'totalRevenue', 
            'orders'
        ));
    }
}