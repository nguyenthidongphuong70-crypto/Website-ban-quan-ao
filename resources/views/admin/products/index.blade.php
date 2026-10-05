@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')

@section('content')

<div class="admin-card">
    <div class="card-top">
        <h2 class="card-top-title">Danh sách sản phẩm</h2>
        <a href="{{ route('admin.products.create') }}" class="btn-ad btn-ad-dark">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Thêm sản phẩm
        </a>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('admin.products.index') }}"
          style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px;">
        <input
            type="text"
            name="search"
            class="form-input"
            placeholder="Tìm theo tên hoặc mô tả..."
            value="{{ request('search') }}"
            style="max-width:260px;"
        >
        <select name="category_id" class="form-select" style="max-width:200px;">
            <option value="">Tất cả danh mục</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-ad btn-ad-outline">Lọc</button>
        @if(request('search') || request('category_id'))
            <a href="{{ route('admin.products.index') }}" class="btn-ad btn-ad-outline">Đặt lại</a>
        @endif
    </form>

    {{-- Table --}}
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:60px;">ID</th>
                <th style="width:72px;">Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá bán</th>
                <th>Size / Màu</th>
                <th>Tồn kho</th>
                <th style="width:160px; text-align:right;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td style="color:var(--ad-muted); font-size:12px;">#{{ $product->id }}</td>
                    <td>
                        <div style="width:52px; height:64px; overflow:hidden; background:#faf7f4;">
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->name }}"
                                style="width:100%; height:100%; object-fit:cover;"
                            >
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:400; font-size:13px;">{{ $product->name }}</div>
                        @if($product->description)
                            <div style="font-size:11px; color:var(--ad-muted); max-width:240px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $product->description }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="badge-ad neutral">
                            {{ $product->category?->name ?? 'Chưa phân loại' }}
                        </span>
                    </td>
                    <td style="font-weight:400;">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                    </td>
                    <td style="font-size:12px; color:var(--ad-muted);">
                        {{ $product->size ?: '—' }} / {{ $product->color ?: '—' }}
                    </td>
                    <td>
                        @if($product->stock > 10)
                            <span class="badge-ad success">{{ $product->stock }} cái</span>
                        @elseif($product->stock > 0)
                            <span class="badge-ad warning">Còn {{ $product->stock }}</span>
                        @else
                            <span class="badge-ad danger">Hết hàng</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-ad btn-ad-outline">
                            Sửa
                        </a>

                        {{-- Delete form --}}
                        <form
                            id="del-prod-{{ $product->id }}"
                            action="{{ route('admin.products.destroy', $product) }}"
                            method="POST"
                            style="display:inline;"
                        >
                            @csrf
                            @method('DELETE')
                        </form>
                        <button
                            type="button"
                            class="btn-ad btn-ad-danger"
                            onclick="openDeleteModal('del-prod-{{ $product->id }}', '{{ addslashes($product->name) }}')"
                        >
                            Xóa
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:var(--ad-muted); padding:40px;">
                        Không tìm thấy sản phẩm nào.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        {{ $products->links() }}
    </div>
</div>

{{-- Delete confirm modal --}}
<div class="delete-modal-overlay" id="delete-modal-overlay">
    <div class="delete-modal">
        <h3 class="delete-modal-title">Xác nhận xóa</h3>
        <p class="delete-modal-body">
            Bạn có chắc muốn xóa sản phẩm <strong id="delete-item-name"></strong>?<br>
            Ảnh sản phẩm sẽ bị xóa vĩnh viễn. Thao tác không thể hoàn tác.
        </p>
        <div class="delete-modal-actions">
            <button id="delete-confirm-btn" class="btn-ad btn-ad-danger" style="flex:1;">Xác nhận xóa</button>
            <button onclick="closeDeleteModal()" class="btn-ad btn-ad-outline" style="flex:1;">Hủy bỏ</button>
        </div>
    </div>
</div>

@endsection
