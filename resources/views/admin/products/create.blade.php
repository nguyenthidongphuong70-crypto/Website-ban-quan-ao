@extends('admin.layout')

@section('title', 'Thêm sản phẩm mới')

@section('content')

<div class="admin-card">
    <div class="card-top">
        <h2 class="card-top-title">Thêm sản phẩm mới</h2>
        <a href="{{ route('admin.products.index') }}" class="btn-ad btn-ad-outline">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; max-width:780px;">

            {{-- Tên sản phẩm --}}
            <div class="form-group" style="grid-column:span 2;">
                <label for="name" class="form-label">Tên sản phẩm <span style="color:#991b1b;">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-input"
                    placeholder="Ví dụ: Áo thun trơn nam cổ tròn"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Danh mục --}}
            <div class="form-group">
                <label for="category_id" class="form-label">Danh mục <span style="color:#991b1b;">*</span></label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <option value="">— Chọn danh mục —</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Giá bán --}}
            <div class="form-group">
                <label for="price" class="form-label">Giá bán (VNĐ) <span style="color:#991b1b;">*</span></label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    id="price"
                    name="price"
                    class="form-input"
                    placeholder="150000"
                    value="{{ old('price') }}"
                    required
                >
                @error('price')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tồn kho --}}
            <div class="form-group">
                <label for="stock" class="form-label">Số lượng tồn kho <span style="color:#991b1b;">*</span></label>
                <input
                    type="number"
                    min="0"
                    id="stock"
                    name="stock"
                    class="form-input"
                    placeholder="50"
                    value="{{ old('stock', 0) }}"
                    required
                >
                @error('stock')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Size --}}
            <div class="form-group">
                <label for="size" class="form-label">Kích thước (Size)</label>
                <input
                    type="text"
                    id="size"
                    name="size"
                    class="form-input"
                    placeholder="S, M, L, XL, XXL..."
                    value="{{ old('size') }}"
                >
                @error('size')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Màu sắc --}}
            <div class="form-group">
                <label for="color" class="form-label">Màu sắc</label>
                <input
                    type="text"
                    id="color"
                    name="color"
                    class="form-input"
                    placeholder="Đen, Trắng, Xanh navy..."
                    value="{{ old('color') }}"
                >
                @error('color')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Hình ảnh --}}
            <div class="form-group">
                <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    class="form-input"
                    accept="image/*"
                    onchange="previewImage(this)"
                    style="padding: 10px 14px; height:auto; cursor:pointer;"
                >
                <div class="img-preview-wrap" id="img-preview" style="display:none;">
                    <img id="img-preview-src" src="" alt="Preview">
                </div>
                <p class="form-hint">Định dạng: jpg, png, webp. Tối đa 2MB.</p>
                @error('image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mô tả --}}
            <div class="form-group" style="grid-column:span 2;">
                <label for="description" class="form-label">Mô tả chi tiết sản phẩm</label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    class="form-textarea"
                    placeholder="Chất liệu cotton 100%, thoáng mát, co giãn 4 chiều..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-ad btn-ad-dark">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu sản phẩm
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn-ad btn-ad-outline">Hủy bỏ</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const wrap = document.getElementById('img-preview');
    const img  = document.getElementById('img-preview-src');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            wrap.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
