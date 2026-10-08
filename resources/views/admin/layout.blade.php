@extends('layouts.app')

{{-- ====================================================================
     AUREN ADMIN — GIAO DIỆN QUẢN TRỊ DÙNG CHUNG LAYOUT USER
     Admin = User UI + Admin UI (không tách biệt giao diện riêng)
     Kế thừa trực tiếp layouts/app.blade.php
==================================================================== --}}

@section('title')
    @yield('title', 'Quản trị hệ thống')
@endsection

@section('extra-css')
<style>
/* ====================================================================
   AUREN ADMIN UI COMPONENTS (HÒA HỢP VỚI GIAO DIỆN USER)
==================================================================== */
:root {
    --ad-accent:        #c9a96e;
    --ad-card-bg:       #ffffff;
    --ad-border:        #e8e3de;
    --ad-text:          #1a1917;
    --ad-muted:         #7a7570;

    --ad-success-bg:    #f0fdf4;
    --ad-success-txt:   #166534;
    --ad-success-bdr:   #bbf7d0;

    --ad-danger-bg:     #fef2f2;
    --ad-danger-txt:    #991b1b;
    --ad-danger-bdr:    #fecaca;

    --ad-warning-bg:    #fffbeb;
    --ad-warning-txt:   #92400e;
}

/* ---- ADMIN SUBNAV TOOLBAR (THANH ĐIỀU HƯỚNG QUẢN TRỊ NẰM DƯỚI HEADER USER) ---- */
.admin-toolbar-strip {
    background: #111110;
    color: #ffffff;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.admin-toolbar-inner {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    min-height: 48px;
    flex-wrap: wrap;
}

.admin-toolbar-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.admin-toolbar-badge {
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--ad-accent);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.admin-toolbar-tabs {
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

.admin-toolbar-tab {
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.65);
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.admin-toolbar-tab:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.08);
}

.admin-toolbar-tab.active {
    color: #ffffff;
    background: rgba(201, 169, 110, 0.2);
    border: 1px solid rgba(201, 169, 110, 0.35);
}

.admin-toolbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 11px;
}

.admin-toolbar-right a {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: color 0.2s ease;
}

.admin-toolbar-right a:hover {
    color: #ffffff;
}

/* ---- ADMIN CONTENT CONTAINER ---- */
.admin-main-wrap {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 32px var(--spacing-md) 64px;
}

/* Flash alerts */
.flash-alert {
    padding: 13px 18px;
    margin-bottom: 20px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-left: 3px solid;
    border-radius: 10px;
}

.flash-alert.success {
    background: var(--ad-success-bg);
    color: var(--ad-success-txt);
    border-color: var(--ad-success-txt);
}

.flash-alert.danger {
    background: var(--ad-danger-bg);
    color: var(--ad-danger-txt);
    border-color: var(--ad-danger-txt);
}

/* Cards */
.admin-card {
    background: var(--ad-card-bg);
    border: 1px solid var(--ad-border);
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
    padding: 28px;
    margin-bottom: 24px;
}

.card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--ad-border);
    flex-wrap: wrap;
    gap: 14px;
}

.card-top-title {
    font-family: var(--font-display);
    font-size: 24px;
    font-weight: 400;
    color: var(--clr-black);
    letter-spacing: -0.01em;
}

/* Table */
.admin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.admin-table th {
    padding: 12px 14px;
    text-align: left;
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--ad-muted);
    background: var(--clr-offwhite);
    border-bottom: 1px solid var(--ad-border);
}

.admin-table td {
    padding: 14px;
    border-bottom: 1px solid var(--ad-border);
    font-weight: 300;
    vertical-align: middle;
}

.admin-table tbody tr:last-child td { border-bottom: none; }

.admin-table tbody tr {
    transition: background 0.2s ease;
}

.admin-table tbody tr:hover {
    background: #faf7f4;
}

/* Buttons */
.btn-ad {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0 18px;
    height: 38px;
    font-family: var(--font-body);
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: 1px solid;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    vertical-align: middle;
    text-decoration: none;
}

.btn-ad-dark {
    background: #111110;
    color: #ffffff;
    border-color: #111110;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.btn-ad-dark:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(17, 17, 16, 0.28);
    color: #ffffff;
}

.btn-ad-outline {
    background: transparent;
    color: var(--clr-black);
    border-color: var(--ad-border);
    border-radius: 8px;
}
.btn-ad-outline:hover {
    border-color: var(--clr-black);
    color: var(--clr-black);
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.btn-ad-danger {
    background: transparent;
    color: #991b1b;
    border-color: #fecaca;
    border-radius: 8px;
}
.btn-ad-danger:hover {
    background: #fef2f2;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(153, 27, 27, 0.2);
}

.btn-ad svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

/* Form */
.form-section {
    max-width: 680px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--ad-muted);
    margin-bottom: 8px;
}

.form-input {
    width: 100%;
    height: 44px;
    padding: 0 14px;
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 300;
    color: var(--clr-black);
    background: var(--clr-white);
    border: 1px solid var(--ad-border);
    border-radius: 8px;
    outline: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
    -webkit-appearance: none;
    appearance: none;
}

.form-input:focus {
    border-color: var(--clr-black);
    box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.06);
}
.form-input::placeholder { color: var(--ad-muted); }

.form-textarea {
    width: 100%;
    padding: 12px 14px;
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 300;
    color: var(--clr-black);
    background: var(--clr-white);
    border: 1px solid var(--ad-border);
    border-radius: 8px;
    outline: none;
    resize: vertical;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    transition: all 0.2s ease;
    min-height: 100px;
}

.form-textarea:focus {
    border-color: var(--clr-black);
    box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.06);
}

.form-select {
    width: 100%;
    height: 44px;
    padding: 0 36px 0 14px;
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 300;
    color: var(--clr-black);
    background: var(--clr-white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%231a1917' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") right 14px center no-repeat;
    border: 1px solid var(--ad-border);
    border-radius: 8px;
    outline: none;
    cursor: pointer;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    -webkit-appearance: none;
    appearance: none;
    transition: all 0.2s ease;
}

.form-select:focus {
    border-color: var(--clr-black);
    box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.06);
}

.form-error {
    margin-top: 6px;
    font-size: 12px;
    color: #991b1b;
}

.form-hint {
    margin-top: 6px;
    font-size: 12px;
    color: var(--ad-muted);
}

.img-preview-wrap {
    margin-top: 10px;
    width: 120px;
    height: 150px;
    overflow: hidden;
    border: 1px solid var(--ad-border);
    border-radius: 8px;
    background: #faf7f4;
}

.img-preview-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-top: 24px;
    border-top: 1px solid var(--ad-border);
    margin-top: 8px;
}

/* Badges */
.badge-ad {
    display: inline-block;
    padding: 3px 8px;
    font-size: 9px;
    font-weight: 400;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: 1px solid;
    border-radius: 4px;
}

.badge-ad.success {
    color: var(--ad-success-txt);
    border-color: var(--ad-success-bdr);
    background: var(--ad-success-bg);
}

.badge-ad.danger {
    color: var(--ad-danger-txt);
    border-color: var(--ad-danger-bdr);
    background: var(--ad-danger-bg);
}

.badge-ad.warning {
    color: var(--ad-warning-txt);
    border-color: #fde68a;
    background: var(--ad-warning-bg);
}

.badge-ad.neutral {
    color: var(--ad-muted);
    border-color: var(--ad-border);
    background: #faf7f4;
}

/* Pagination */
.pagination-wrap {
    margin-top: 24px;
    display: flex;
    justify-content: center;
}

/* Delete modal */
.delete-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10, 10, 10, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.delete-modal-overlay.open { display: flex; }

.delete-modal {
    background: var(--clr-white);
    padding: 32px;
    max-width: 440px;
    width: 100%;
    border-radius: 16px;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
    border: 1px solid var(--ad-border);
}

.delete-modal-title {
    font-family: var(--font-display);
    font-size: 24px;
    font-weight: 400;
    margin-bottom: 12px;
    color: var(--clr-black);
}

.delete-modal-body {
    font-size: 13px;
    color: var(--ad-muted);
    margin-bottom: 28px;
    line-height: 1.6;
}

.delete-modal-actions {
    display: flex;
    gap: 10px;
}

@media (max-width: 768px) {
    .admin-toolbar-inner {
        padding: 8px var(--spacing-md);
        gap: 8px;
    }
    .admin-toolbar-tab {
        font-size: 10px;
        padding: 6px 10px;
    }
    .admin-main-wrap {
        padding: 20px var(--spacing-sm) 48px;
    }
    .admin-card {
        padding: 18px;
    }
}
</style>
@endsection

@section('content')

{{-- ====================================================================
     ADMIN TOOLBAR — NẰM TRONG GIAO DIỆN USER
     Giúp Admin chuyển đổi nhanh giữa các module quản trị
==================================================================== --}}
<div class="admin-toolbar-strip">
    <div class="admin-toolbar-inner">
        <div class="admin-toolbar-left">
            <span class="admin-toolbar-badge">
                <span>♤</span> AUREN ADMIN
            </span>

            <nav class="admin-toolbar-tabs" aria-label="Điều hướng quản trị">
                @if(Route::has('admin.dashboard'))
                    <a href="{{ route('admin.dashboard') }}"
                       class="admin-toolbar-tab {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        📊 Dashboard
                    </a>
                @endif

                <a href="{{ route('admin.products.index') }}"
                   class="admin-toolbar-tab {{ request()->is('admin/products*') ? 'active' : '' }}">
                    👕 Sản phẩm
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="admin-toolbar-tab {{ request()->is('admin/categories*') ? 'active' : '' }}">
                    📁 Danh mục
                </a>

                @if(Route::has('admin.orders.index'))
                    <a href="{{ route('admin.orders.index') }}"
                       class="admin-toolbar-tab {{ request()->is('admin/orders*') ? 'active' : '' }}">
                        📦 Đơn hàng
                    </a>
                @elseif(Route::has('admin.orders'))
                    <a href="{{ route('admin.orders') }}"
                       class="admin-toolbar-tab {{ request()->is('admin/orders*') ? 'active' : '' }}">
                        📦 Đơn hàng
                    </a>
                @endif
            </nav>
        </div>

        <div class="admin-toolbar-right">
            <a href="{{ route('products.index') }}">
                Xem trang bán hàng ↗
            </a>
        </div>
    </div>
</div>

{{-- ====================================================================
     NỘI DUNG CHỨC NĂNG QUẢN TRỊ (TABLE, FORM, ...)
==================================================================== --}}
<div class="admin-main-wrap">

    {{-- Flash notifications --}}
    @if (session('success'))
        <div class="flash-alert success" role="alert">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flash-alert danger" role="alert">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="flash-alert danger" role="alert">
            <div>
                <strong style="display:block; margin-bottom:6px;">Vui lòng kiểm tra lại:</strong>
                <ul style="padding-left: 16px; font-size: 12px; line-height: 1.8;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Render view admin con (products, categories, orders...) --}}
    @yield('content')
</div>

{{-- Modal xác nhận xóa dùng chung cho các view admin con --}}
<div class="delete-modal-overlay" id="delete-modal-overlay">
    <div class="delete-modal">
        <h3 class="delete-modal-title">Xác nhận xóa</h3>
        <p class="delete-modal-body">
            Bạn có chắc chắn muốn xóa <strong id="delete-item-name">mục này</strong>?<br>
            Hành động này không thể hoàn tác.
        </p>
        <div class="delete-modal-actions">
            <button type="button" id="delete-confirm-btn" class="btn-ad btn-ad-danger" style="flex: 1;">
                Xác nhận xóa
            </button>
            <button type="button" onclick="closeDeleteModal()" class="btn-ad btn-ad-outline" style="flex: 1;">
                Hủy bỏ
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    window.openDeleteModal = function (formId, itemName) {
        const overlay = document.getElementById('delete-modal-overlay');
        const nameEl  = document.getElementById('delete-item-name');
        const form    = document.getElementById(formId);

        if (!overlay || !form) return;

        if (nameEl) nameEl.textContent = itemName || 'mục này';
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';

        const confirmBtn = document.getElementById('delete-confirm-btn');
        if (confirmBtn) {
            confirmBtn.onclick = () => form.submit();
        }
    };

    window.closeDeleteModal = function () {
        const overlay = document.getElementById('delete-modal-overlay');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    };

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') window.closeDeleteModal();
    });
})();
</script>
@endpush
