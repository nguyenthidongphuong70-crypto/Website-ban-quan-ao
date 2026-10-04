<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị') — AUREN Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --ad-sidebar-bg:     #111110;
            --ad-sidebar-active: #1c1c1a;
            --ad-sidebar-hover:  #1a1a18;
            --ad-sidebar-border: rgba(255,255,255,0.06);
            --ad-sidebar-text:   rgba(255,255,255,0.55);
            --ad-sidebar-active-text: #ffffff;
            --ad-sidebar-accent: #c9a96e;

            --ad-content-bg:    #f5f2ee;
            --ad-card-bg:       #ffffff;
            --ad-border:        #e8e3de;
            --ad-text:          #1a1917;
            --ad-muted:         #7a7570;

            --ad-success-bg:  #f0fdf4;
            --ad-success-txt: #166534;
            --ad-success-bdr: #bbf7d0;
            --ad-danger-bg:   #fef2f2;
            --ad-danger-txt:  #991b1b;
            --ad-danger-bdr:  #fecaca;
            --ad-warning-bg:  #fffbeb;
            --ad-warning-txt: #92400e;

            --font-display:  'Cormorant Garamond', Georgia, serif;
            --font-body:     'DM Sans', -apple-system, sans-serif;

            --ad-sidebar-w:  240px;
            --ad-topbar-h:   60px;

            --transition: 200ms ease;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { font-size: 15px; -webkit-font-smoothing: antialiased; }

        body {
            font-family: var(--font-body);
            font-weight: 300;
            color: var(--ad-text);
            background: var(--ad-content-bg);
            display: flex;
            min-height: 100dvh;
            overflow-x: hidden;
        }

        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        button { font-family: inherit; cursor: pointer; }

        .admin-sidebar {
            width: var(--ad-sidebar-w);
            background: var(--ad-sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            border-right: 1px solid var(--ad-sidebar-border);
            transition: transform var(--transition);
        }

        .sidebar-brand {
            padding: 0 20px;
            height: var(--ad-topbar-h);
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--ad-sidebar-border);
            flex-shrink: 0;
        }

        .sidebar-brand-logo {
            font-family: var(--font-display);
            font-size: 17px;
            font-weight: 400;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #ffffff;
        }

        .sidebar-brand-logo .brand-suit { color: var(--ad-sidebar-accent); font-size: 13px; }

        .sidebar-brand-sub {
            font-size: 9px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ad-sidebar-text);
        }

        .sidebar-section-label {
            font-size: 9px;
            font-weight: 400;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 20px 20px 8px;
        }

        .sidebar-nav {
            list-style: none;
            flex-grow: 1;
            overflow-y: auto;
            padding: 8px 0;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

        .sidebar-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 300;
            color: var(--ad-sidebar-text);
            transition: background var(--transition), color var(--transition), border-left-color var(--transition);
            border-left: 2px solid transparent;
        }

        .sidebar-item a:hover {
            background: var(--ad-sidebar-hover);
            color: #ffffff;
            border-left-color: rgba(201,169,110,0.3);
        }

        .sidebar-item.active a {
            background: var(--ad-sidebar-active);
            color: var(--ad-sidebar-active-text);
            border-left-color: var(--ad-sidebar-accent);
        }

        .sidebar-icon {
            width: 18px;
            height: 18px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .sidebar-item.active .sidebar-icon,
        .sidebar-item:hover .sidebar-icon {
            opacity: 1;
        }

        .sidebar-divider {
            border: none;
            border-top: 1px solid var(--ad-sidebar-border);
            margin: 8px 16px;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--ad-sidebar-border);
            flex-shrink: 0;
        }

        .sidebar-footer-text {
            font-size: 11px;
            color: rgba(255,255,255,0.25);
            letter-spacing: 0.06em;
        }

        .admin-main {
            flex-grow: 1;
            min-width: 0;
            margin-left: var(--ad-sidebar-w);
            display: flex;
            flex-direction: column;
            min-height: 100dvh;
        }

        .admin-topbar {
            height: var(--ad-topbar-h);
            background: var(--ad-card-bg);
            border-bottom: 1px solid var(--ad-border);
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 400;
            color: var(--ad-text);
            letter-spacing: 0.02em;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 4px 10px;
            background: var(--ad-sidebar-bg);
            color: var(--ad-sidebar-accent);
            border: 1px solid rgba(201,169,110,0.3);
        }

        .topbar-view-store {
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ad-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color var(--transition);
        }

        .topbar-view-store:hover { color: var(--ad-text); }

        .admin-content {
            flex-grow: 1;
            padding: 28px;
        }

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

        .admin-card {
            background: var(--ad-card-bg);
            border: 1px solid var(--ad-border);
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--ad-border);
        }

        .card-top-title {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 400;
            color: var(--ad-text);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .admin-table th {
            padding: 10px 14px;
            text-align: left;
            font-size: 9px;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--ad-muted);
            background: #faf7f4;
            border-bottom: 1px solid var(--ad-border);
        }

        .admin-table td {
            padding: 13px 14px;
            border-bottom: 1px solid var(--ad-border);
            font-weight: 300;
            vertical-align: middle;
        }

        .admin-table tbody tr:last-child td { border-bottom: none; }

        .admin-table tbody tr {
            transition: background var(--transition);
        }

        .admin-table tbody tr:hover {
            background: #faf7f4;
        }

        .btn-ad {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0 18px;
            height: 36px;
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 400;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            border: 1px solid;
            border-radius: 8px;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
            vertical-align: middle;
        }

        .btn-ad-dark {
            background: var(--ad-sidebar-bg);
            color: #ffffff;
            border-color: var(--ad-sidebar-bg);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .btn-ad-dark:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(17, 17, 16, 0.28);
        }

        .btn-ad-outline {
            background: transparent;
            color: var(--ad-text);
            border-color: var(--ad-border);
            border-radius: 8px;
        }
        .btn-ad-outline:hover {
            border-color: var(--ad-text);
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
            color: var(--ad-text);
            background: var(--ad-card-bg);
            border: 1px solid var(--ad-border);
            border-radius: 8px;
            outline: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: all var(--transition);
            -webkit-appearance: none;
            appearance: none;
        }

        .form-input:focus {
            border-color: var(--ad-text);
            box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.06);
        }
        .form-input::placeholder { color: var(--ad-muted); }

        .form-textarea {
            width: 100%;
            padding: 12px 14px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 300;
            color: var(--ad-text);
            background: var(--ad-card-bg);
            border: 1px solid var(--ad-border);
            border-radius: 8px;
            outline: none;
            resize: vertical;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: all var(--transition);
            min-height: 100px;
        }

        .form-textarea:focus {
            border-color: var(--ad-text);
            box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.06);
        }

        .form-select {
            width: 100%;
            height: 44px;
            padding: 0 36px 0 14px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 300;
            color: var(--ad-text);
            background: var(--ad-card-bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%231a1917' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") right 14px center no-repeat;
            border: 1px solid var(--ad-border);
            border-radius: 8px;
            outline: none;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            -webkit-appearance: none;
            appearance: none;
            transition: all var(--transition);
        }

        .form-select:focus {
            border-color: var(--ad-text);
            box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.06);
        }

        .form-error {
            margin-top: 6px;
            font-size: 12px;
            color: var(--ad-danger-txt);
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

        .badge-ad {
            display: inline-block;
            padding: 3px 8px;
            font-size: 9px;
            font-weight: 400;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            border: 1px solid;
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

        .pagination-wrap {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .delete-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10,10,10,0.5);
            z-index: 9000;
            align-items: center;
            justify-content: center;
        }

        .delete-modal-overlay.open { display: flex; }

        .delete-modal {
            background: var(--ad-card-bg);
            padding: 32px;
            max-width: 420px;
            width: 90%;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
        }

        .delete-modal-title {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 400;
            margin-bottom: 12px;
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
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
            .admin-content { padding: 16px; }
            .admin-topbar { padding: 0 16px; }
        }

        @yield('extra-css')
    </style>
</head>
<body>

    {{-- ========== SIDEBAR ========== --}}
    <aside class="admin-sidebar" id="admin-sidebar">

        <div class="sidebar-brand">
            <div>
                <div class="sidebar-brand-logo">
                    <span class="brand-suit">♤</span> AUREN
                </div>
                <div class="sidebar-brand-sub">Admin Panel</div>
            </div>
        </div>

        <p class="sidebar-section-label">Nội dung</p>

        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <a href="{{ url('/admin/dashboard') }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Bảng điều khiển
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <a href="{{ Route::has('admin.categories.index') ? route('admin.categories.index') : url('/admin/categories') }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    Danh mục
                </a>
            </li>
            <li class="sidebar-item {{ request()->is('admin/products*') ? 'active' : '' }}">
                <a href="{{ Route::has('admin.products.index') ? route('admin.products.index') : url('/admin/products') }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                    Sản phẩm
                </a>
            </li>

            <hr class="sidebar-divider">

            <p class="sidebar-section-label" style="padding-top: 0;">Đơn hàng</p>

            <li class="sidebar-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <a href="{{ url('/admin/orders') }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    Quản lý đơn hàng
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="sidebar-item">
                <a href="{{ route('products.index') }}" target="_blank">
                    <svg class="sidebar-icon" viewBox="0 0 24 24">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Xem trang bán hàng ↗
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <p class="sidebar-footer-text">Người 1 — Sản phẩm &amp; Danh mục</p>
        </div>
    </aside>

    {{-- ========== MAIN CONTENT ========== --}}
    <div class="admin-main">

        {{-- Topbar --}}
        <header class="admin-topbar">
            <h1 class="topbar-title">@yield('title', 'Quản trị hệ thống')</h1>
            <div class="topbar-right">
                <a href="{{ route('products.index') }}" target="_blank" class="topbar-view-store">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Xem shop
                </a>
                <span class="topbar-badge">Admin</span>
            </div>
        </header>

        {{-- Content --}}
        <div class="admin-content">

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

            {{-- Main yield --}}
            @yield('content')
        </div>
    </div>

    {{-- ========== SHARED JS ========== --}}
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

    @stack('scripts')
</body>
</html>
