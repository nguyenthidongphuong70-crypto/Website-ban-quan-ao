@extends('admin.layout')

@section('title', 'Thêm danh mục mới')

@section('content')

<div class="admin-card">
    <div class="card-top">
        <h2 class="card-top-title">Thêm danh mục mới</h2>
        <a href="{{ route('admin.categories.index') }}" class="btn-ad btn-ad-outline">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="form-section">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Tên danh mục <span style="color:#991b1b;">*</span></label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-input"
                placeholder="Ví dụ: Áo sơ mi, Áo khoác, Áo Polo..."
                value="{{ old('name') }}"
                required
                autofocus
            >
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-ad btn-ad-dark">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu danh mục
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn-ad btn-ad-outline">Hủy bỏ</a>
        </div>
    </form>
</div>

@endsection
