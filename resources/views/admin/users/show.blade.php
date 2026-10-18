
@extends('layouts.app')

@section('title', 'Chi tiết người dùng')

@push('head-styles')
    @include('admin.users._styles')
@endpush

@section('content')

<div class="um-container">

    <a href="{{ route('admin.users.index') }}" class="um-muted">
        ← Quay lại danh sách người dùng
    </a>

    <h1 class="um-title" style="margin-top:20px;">
        {{ $user->full_name }}
    </h1>

    <p class="um-subtitle">
        Thông tin tài khoản và lịch sử mua hàng tại AUREN
    </p>

    <div class="um-card">

        <h2 style="margin-bottom:20px;">
            Thông tin khách hàng
        </h2>

        <div class="um-info">

            <div>
                <span>Mã người dùng</span>
                <strong>#{{ $user->id }}</strong>
            </div>

            <div>
                <span>Họ tên</span>
                <strong>{{ $user->full_name }}</strong>
            </div>

            <div>
                <span>Email</span>
                <strong>{{ $user->email }}</strong>
            </div>

            <div>
                <span>Số điện thoại</span>
                <strong>{{ $user->phone ?: 'Chưa cập nhật' }}</strong>
            </div>

            <div>
                <span>Địa chỉ</span>
                <strong>{{ $user->address ?: 'Chưa cập nhật' }}</strong>
            </div>

            <div>
                <span>Vai trò</span>
                <strong>
                    {{ $user->isAdmin() ? 'Admin' : 'Customer' }}
                </strong>
            </div>

            <div>
                <span>Trạng thái</span>

                @if($user->isBlocked())
                    <strong style="color:#a42626;">Đã khóa</strong>
                @else
                    <strong style="color:#176a39;">Đang hoạt động</strong>
                @endif
            </div>

            <div>
                <span>Tổng số đơn hàng</span>
                <strong>{{ $user->orders_count }}</strong>
            </div>

        </div>

        @if(!$user->isAdmin())

        <form
            method="POST"
            action="{{ route('admin.users.block', $user) }}"
            onsubmit="return confirm('Xác nhận thay đổi trạng thái tài khoản?')"
            style="margin-top:24px;"
        >
            @csrf
            @method('PATCH')

            <input
                type="hidden"
                name="is_blocked"
                value="{{ $user->isBlocked() ? 0 : 1 }}"
            >

            <button type="submit"
                    class="um-btn {{ $user->isBlocked() ? '' : 'um-btn-danger' }}">

                {{ $user->isBlocked() ? 'MỞ KHÓA TÀI KHOẢN' : 'KHÓA TÀI KHOẢN' }}

            </button>

        </form>

        @endif

    </div>

    <div class="um-card">

        <h2 style="margin-bottom:20px;">
            Lịch sử đơn hàng ({{ $user->orders_count }})
        </h2>

        <div class="um-table-wrap">

            <table class="um-table">

                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Người nhận</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($orders as $order)

                    <tr>

                        <td>#{{ $order->id }}</td>

                        <td>
                            {{ $order->receiver_name }}
                        </td>

                        <td>
                            {{ number_format((float) $order->total_price, 0, ',', '.') }} đ
                        </td>

                        <td>
                            {{ $order->payment_method ?: 'Chưa xác định' }}
                        </td>

                        <td>
                            {{ $order->status }}
                        </td>

                        <td>
                            <a
                                class="um-btn um-btn-outline"
                                href="{{ route('admin.orders.show', $order->id) }}"
                            >
                                Xem đơn
                            </a>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" style="text-align:center;padding:30px;">
                            Khách hàng chưa có đơn hàng.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="um-pagination">

            <span class="um-muted">
                Trang {{ $orders->currentPage() }} /
                {{ max(1, $orders->lastPage()) }}
            </span>

            <div class="um-actions">

                @if($orders->previousPageUrl())
                    <a class="um-btn um-btn-outline"
                       href="{{ $orders->previousPageUrl() }}">
                        ← Trước
                    </a>
                @endif

                @if($orders->nextPageUrl())
                    <a class="um-btn um-btn-outline"
                       href="{{ $orders->nextPageUrl() }}">
                        Tiếp →
                    </a>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection
