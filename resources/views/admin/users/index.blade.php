
@extends('layouts.app')

@section('title', 'Quản lý người dùng')

@push('head-styles')
    @include('admin.users._styles')
@endpush

@section('content')

<div class="um-container">

    <h1 class="um-title">Quản lý người dùng</h1>

    <p class="um-subtitle">
        AUREN ADMIN — Xem thông tin, đơn hàng và trạng thái tài khoản.
    </p>

    <div class="um-card">

        <form action="{{ route('admin.users.index') }}"
              method="GET"
              class="um-form">

            <input
                class="um-input"
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Tìm tên, email hoặc số điện thoại"
            >

            <select name="status" class="um-select">
                <option value="all" @selected($status === 'all')>
                    Tất cả trạng thái
                </option>

                <option value="active" @selected($status === 'active')>
                    Đang hoạt động
                </option>

                <option value="blocked" @selected($status === 'blocked')>
                    Đã khóa
                </option>
            </select>

            <button type="submit" class="um-btn">
                TÌM KIẾM
            </button>

        </form>

    </div>

    <div class="um-card">

        <div class="um-table-wrap">

            <table class="um-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                    <tr>

                        <td>{{ $user->id }}</td>

                        <td>
                            <strong>{{ $user->full_name }}</strong>
                            <div class="um-muted">
                                {{ $user->email }}
                            </div>
                        </td>

                        <td>{{ $user->phone ?: 'Chưa có' }}</td>

                        <td>
                            {{ $user->isAdmin() ? 'Admin' : 'Customer' }}
                        </td>

                        <td>{{ $user->orders_count }}</td>

                        <td>
                            @if($user->isBlocked())
                                <span class="um-badge um-badge-blocked">
                                    Đã khóa
                                </span>
                            @else
                                <span class="um-badge">
                                    Hoạt động
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="um-actions">

                                <a class="um-btn um-btn-outline"
                                   href="{{ route('admin.users.show', $user) }}">
                                    Chi tiết
                                </a>

                                @if(!$user->isAdmin())

                                <form
                                    method="POST"
                                    action="{{ route('admin.users.block', $user) }}"
                                    onsubmit="return confirm('Xác nhận thay đổi trạng thái tài khoản này?')"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="hidden"
                                        name="is_blocked"
                                        value="{{ $user->isBlocked() ? 0 : 1 }}"
                                    >

                                    <button
                                        type="submit"
                                        class="um-btn {{ $user->isBlocked() ? '' : 'um-btn-danger' }}"
                                    >
                                        {{ $user->isBlocked() ? 'Mở khóa' : 'Khóa' }}
                                    </button>

                                </form>

                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" style="text-align:center;padding:30px;">
                            Không tìm thấy người dùng.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="um-pagination">

            <span class="um-muted">
                Trang {{ $users->currentPage() }} / {{ max(1, $users->lastPage()) }}
                — Tổng {{ $users->total() }} người dùng
            </span>

            <div class="um-actions">

                @if($users->previousPageUrl())
                    <a class="um-btn um-btn-outline"
                       href="{{ $users->previousPageUrl() }}">
                        ← Trước
                    </a>
                @endif

                @if($users->nextPageUrl())
                    <a class="um-btn um-btn-outline"
                       href="{{ $users->nextPageUrl() }}">
                        Tiếp →
                    </a>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection
