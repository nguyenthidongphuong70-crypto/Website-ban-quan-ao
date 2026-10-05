@extends('admin.layout')

@section('title', 'Quản lý danh mục')

@section('content')

<div class="admin-card">
    <div class="card-top">
        <h2 class="card-top-title">Danh sách danh mục</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn-ad btn-ad-dark">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm danh mục
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.categories.index') }}"
          style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
        <input
            type="text"
            name="search"
            class="form-input"
            placeholder="Tìm kiếm danh mục..."
            value="{{ request('search') }}"
            style="max-width:280px;"
        >
        <button type="submit" class="btn-ad btn-ad-outline">Tìm kiếm</button>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="btn-ad btn-ad-outline">Đặt lại</a>
        @endif
    </form>

    {{-- Table --}}
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:70px;">ID</th>
                <th>Tên danh mục</th>
                <th style="width:180px;">Số sản phẩm</th>
                <th style="width:180px; text-align:right;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td style="color:var(--ad-muted); font-size:12px;">#{{ $category->id }}</td>
                    <td style="font-weight:400;">{{ $category->name }}</td>
                    <td>
                        <span class="badge-ad neutral">{{ $category->products_count }} sản phẩm</span>
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-ad btn-ad-outline">
                            Sửa
                        </a>

                        {{-- Delete form với confirm --}}
                        <form
                            id="del-cat-{{ $category->id }}"
                            action="{{ route('admin.categories.destroy', $category) }}"
                            method="POST"
                            style="display:inline;"
                        >
                            @csrf
                            @method('DELETE')
                        </form>
                        <button
                            type="button"
                            class="btn-ad btn-ad-danger"
                            onclick="openDeleteModal('del-cat-{{ $category->id }}', '{{ addslashes($category->name) }}')"
                        >
                            Xóa
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:var(--ad-muted); padding:40px;">
                        Chưa có danh mục nào.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        {{ $categories->links() }}
    </div>
</div>

{{-- Delete confirm modal --}}
<div class="delete-modal-overlay" id="delete-modal-overlay">
    <div class="delete-modal">
        <h3 class="delete-modal-title">Xác nhận xóa</h3>
        <p class="delete-modal-body">
            Bạn có chắc muốn xóa danh mục <strong id="delete-item-name"></strong>?<br>
            Thao tác này không thể hoàn tác.
        </p>
        <div class="delete-modal-actions">
            <button id="delete-confirm-btn" class="btn-ad btn-ad-danger" style="flex:1;">Xác nhận xóa</button>
            <button onclick="closeDeleteModal()" class="btn-ad btn-ad-outline" style="flex:1;">Hủy bỏ</button>
        </div>
    </div>
</div>

@endsection
