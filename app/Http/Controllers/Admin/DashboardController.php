<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

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

        // Đơn hàng đã hoàn thành
        $completedOrders = Order::where('status', 'completed')->count();

        // Tổng doanh thu từ đơn đã hoàn thành
        $totalRevenue = Order::where('status', 'completed')
            ->sum('total_price');

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue'
        ));
    }
}