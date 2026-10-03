<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '♤ AUREN') — AUREN</title>

    {{-- Google Fonts: Cormorant Garamond (display) + DM Sans (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --clr-black:      #0a0a0a;
            --clr-white:      #ffffff;
            --clr-ivory:      #f8f5f0;
            --clr-offwhite:   #f2ede8;
            --clr-beige:      #e8e0d6;
            --clr-warm-gray:  #a89f95;
            --clr-mid-gray:   #6b6560;
            --clr-dark-gray:  #2e2b28;

            --font-display:  'Cormorant Garamond', Georgia, serif;
            --font-body:     'DM Sans', -apple-system, sans-serif;

            --nav-height: 72px;
            --transition-base: 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-slow: 600ms cubic-bezier(0.25, 0.46, 0.45, 0.94);

            --spacing-xs:  8px;
            --spacing-sm:  16px;
            --spacing-md:  32px;
            --spacing-lg:  64px;
            --spacing-xl:  96px;
            --spacing-2xl: 128px;

            --max-width: 1280px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            font-weight: 300;
            font-size: 15px;
            line-height: 1.7;
            color: var(--clr-dark-gray);
            background-color: var(--clr-ivory);
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        img, video {
            max-width: 100%;
            display: block;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        #auren-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background: var(--clr-black);
            z-index: 9999;
            transition: width 0.05s linear;
            pointer-events: none;
        }

        #auren-loader {
            position: fixed;
            inset: 0;
            background: var(--clr-ivory);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }

        #auren-loader.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-brand {
            font-family: var(--font-display);
            font-size: clamp(22px, 3vw, 30px);
            font-weight: 400;
            letter-spacing: 0.25em;
            color: var(--clr-black);
            text-transform: uppercase;
            animation: loader-pulse 1s ease-in-out forwards;
            opacity: 0;
        }

        @keyframes loader-pulse {
            0%   { opacity: 0; transform: translateY(8px); }
            50%  { opacity: 1; transform: translateY(0); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .auren-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: var(--nav-height);
            transition: background var(--transition-base),
                        border-color var(--transition-base),
                        backdrop-filter var(--transition-base);
        }

        .auren-nav.transparent {
            background: transparent;
            border-bottom: 1px solid transparent;
        }

        .auren-nav.scrolled {
            background: rgba(248, 245, 240, 0.92);
            border-bottom: 1px solid var(--clr-beige);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .nav-inner {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 var(--spacing-md);
            height: 100%;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
        }

        .nav-brand {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--clr-black);
            transition: opacity var(--transition-base);
            justify-self: center;
            grid-column: 2;
            white-space: nowrap;
        }

        .nav-brand:hover { opacity: 0.7; }

        .nav-brand .brand-suit { font-size: 14px; margin-right: 4px; }

        .nav-links-left {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            list-style: none;
            grid-column: 1;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: var(--spacing-sm);
            grid-column: 3;
        }

        .nav-link-item {
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--clr-black);
            position: relative;
            padding-bottom: 2px;
            transition: opacity var(--transition-base);
        }

        .nav-link-item::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--clr-black);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform var(--transition-base);
        }

        .nav-link-item:hover { opacity: 0.6; }
        .nav-link-item:hover::after,
        .nav-link-item.active::after {
            transform: scaleX(1);
        }
        .nav-link-item.active { opacity: 1; }
        .nav-link-item.active::after { transform: scaleX(1); }

        .nav-icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: var(--clr-black);
            background: none;
            border: none;
            border-radius: 50%;
            transition: background var(--transition-base), opacity var(--transition-base);
            position: relative;
        }

        .nav-icon-btn:hover { opacity: 0.6; }

        .nav-icon-btn svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .cart-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 16px;
            height: 16px;
            background: var(--clr-black);
            color: var(--clr-white);
            font-size: 9px;
            font-weight: 500;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .nav-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            padding: 6px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
        }

        .hamburger-line {
            display: block;
            width: 22px;
            height: 1px;
            background: var(--clr-black);
            transition: transform var(--transition-base), opacity var(--transition-base);
            transform-origin: center;
        }

        .nav-hamburger.open .hamburger-line:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
        }
        .nav-hamburger.open .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }
        .nav-hamburger.open .hamburger-line:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
        }

        .mobile-drawer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--clr-ivory);
            z-index: 999;
            padding: var(--nav-height) var(--spacing-md) var(--spacing-md);
            display: flex;
            flex-direction: column;
            transform: translateX(-100%);
            transition: transform var(--transition-slow);
        }

        .mobile-drawer.open {
            transform: translateX(0);
        }

        .mobile-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-top: var(--spacing-md);
        }

        .mobile-nav-link {
            display: block;
            font-family: var(--font-display);
            font-size: clamp(28px, 6vw, 38px);
            font-weight: 300;
            color: var(--clr-black);
            padding: 14px 0;
            border-bottom: 1px solid var(--clr-beige);
            letter-spacing: 0.05em;
            transition: opacity var(--transition-base), padding-left var(--transition-base);
        }

        .mobile-nav-link:hover {
            opacity: 0.5;
            padding-left: 12px;
        }

        .page-main {
            flex-grow: 1;
            padding-top: var(--nav-height);
        }

        .auren-container {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 var(--spacing-md);
        }

        .auren-section {
            padding: var(--spacing-xl) 0;
        }

        .display-heading {
            font-family: var(--font-display);
            font-size: clamp(36px, 6vw, 72px);
            font-weight: 300;
            line-height: 1.1;
            letter-spacing: -0.01em;
            color: var(--clr-black);
        }

        .section-heading {
            font-family: var(--font-display);
            font-size: clamp(24px, 3.5vw, 40px);
            font-weight: 400;
            line-height: 1.2;
            letter-spacing: 0.02em;
            color: var(--clr-black);
        }

        .label-text {
            font-size: 11px;
            font-weight: 400;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--clr-warm-gray);
        }

        .btn-auren {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 48px;
            padding: 0 32px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all var(--transition-base);
            position: relative;
            overflow: hidden;
            white-space: nowrap;
        }

        .btn-auren::before {
            content: '';
            position: absolute;
            inset: 0;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform var(--transition-base);
        }

        .btn-auren:hover::before { transform: scaleX(1); transform-origin: left; }
        .btn-auren span { position: relative; z-index: 1; }

        .btn-dark {
            background: var(--clr-black);
            color: var(--clr-white);
        }
        .btn-dark::before { background: var(--clr-dark-gray); }

        .btn-outline {
            background: transparent;
            color: var(--clr-black);
            border: 1px solid var(--clr-black);
        }
        .btn-outline::before { background: var(--clr-black); }
        .btn-outline:hover { color: var(--clr-white); }

        .btn-ghost {
            background: transparent;
            color: var(--clr-black);
            border: 1px solid var(--clr-beige);
            height: 40px;
            padding: 0 20px;
        }
        .btn-ghost::before { background: var(--clr-beige); }

        .btn-arrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--clr-black);
            position: relative;
            padding-bottom: 2px;
        }

        .btn-arrow::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--clr-black);
            transform: scaleX(1);
            transform-origin: left;
            transition: transform var(--transition-base);
        }

        .btn-arrow:hover::after { transform: scaleX(0); transform-origin: right; }

        .auren-input {
            width: 100%;
            height: 48px;
            padding: 0 16px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 300;
            color: var(--clr-black);
            background: var(--clr-white);
            border: 1px solid var(--clr-beige);
            border-radius: 0;
            outline: none;
            transition: border-color var(--transition-base);
            -webkit-appearance: none;
            appearance: none;
        }

        .auren-input:focus {
            border-color: var(--clr-black);
        }

        .auren-input::placeholder {
            color: var(--clr-warm-gray);
        }

        .auren-select {
            width: 100%;
            height: 48px;
            padding: 0 36px 0 16px;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 300;
            color: var(--clr-black);
            background: var(--clr-white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%232e2b28' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") right 14px center no-repeat;
            border: 1px solid var(--clr-beige);
            border-radius: 0;
            outline: none;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
            transition: border-color var(--transition-base);
        }

        .auren-select:focus { border-color: var(--clr-black); }

        .auren-divider {
            border: none;
            border-top: 1px solid var(--clr-beige);
            margin: 0;
        }

        .auren-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 400;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            border: 1px solid currentColor;
        }

        .auren-badge.dark {
            color: var(--clr-black);
            border-color: var(--clr-dark-gray);
        }

        .auren-badge.muted {
            color: var(--clr-warm-gray);
            border-color: var(--clr-beige);
        }

        @media (prefers-reduced-motion: no-preference) {
            .reveal,
            .reveal-up,
            .reveal-left,
            .reveal-right,
            .fade-in,
            .scale-in {
                opacity: 0;
                transition: opacity 0.8s ease, transform 0.8s ease;
            }

            .reveal-up     { transform: translateY(30px); }
            .reveal-left   { transform: translateX(-30px); }
            .reveal-right  { transform: translateX(30px); }
            .scale-in      { transform: scale(0.96); }
            .fade-in       {}

            .reveal.is-visible,
            .reveal-up.is-visible,
            .reveal-left.is-visible,
            .reveal-right.is-visible,
            .fade-in.is-visible,
            .scale-in.is-visible {
                opacity: 1;
                transform: none;
            }

            .reveal-delay-1 { transition-delay: 0.1s; }
            .reveal-delay-2 { transition-delay: 0.2s; }
            .reveal-delay-3 { transition-delay: 0.3s; }
            .reveal-delay-4 { transition-delay: 0.4s; }
            .reveal-delay-5 { transition-delay: 0.5s; }
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal, .reveal-up, .reveal-left, .reveal-right, .fade-in, .scale-in {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }

        .auren-footer {
            background: var(--clr-black);
            color: var(--clr-white);
            padding: var(--spacing-xl) 0 var(--spacing-md);
            margin-top: auto;
        }

        .footer-grid {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 var(--spacing-md);
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr 1fr;
            gap: var(--spacing-md);
        }

        .footer-brand {
            font-family: var(--font-display);
            font-size: 26px;
            font-weight: 300;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: var(--spacing-sm);
        }

        .footer-tagline {
            font-size: 13px;
            font-weight: 300;
            color: var(--clr-warm-gray);
            line-height: 1.8;
            max-width: 280px;
        }

        .footer-col-title {
            font-size: 10px;
            font-weight: 400;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--clr-warm-gray);
            margin-bottom: var(--spacing-sm);
        }

        .footer-col-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-col-links a {
            font-size: 13px;
            font-weight: 300;
            color: rgba(255,255,255,0.75);
            transition: color var(--transition-base);
        }

        .footer-col-links a:hover { color: var(--clr-white); }

        .footer-bottom {
            max-width: var(--max-width);
            margin: var(--spacing-lg) auto 0;
            padding: var(--spacing-sm) var(--spacing-md) 0;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.06em;
        }

        .footer-social {
            display: flex;
            gap: var(--spacing-sm);
        }

        .footer-social a {
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            transition: color var(--transition-base);
        }

        .footer-social a:hover { color: var(--clr-white); }

        #back-to-top {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 44px;
            height: 44px;
            background: var(--clr-black);
            color: var(--clr-white);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transform: translateY(16px);
            transition: opacity var(--transition-base), transform var(--transition-base);
            pointer-events: none;
            z-index: 500;
        }

        #back-to-top.visible {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        #back-to-top svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: var(--spacing-md);
            }
        }

        @media (max-width: 768px) {
            :root {
                --nav-height: 60px;
                --spacing-md: 20px;
                --spacing-lg: 40px;
                --spacing-xl: 64px;
            }

            .nav-links-left { display: none; }

            .nav-inner {
                grid-template-columns: auto 1fr auto;
                padding: 0 var(--spacing-md);
            }

            .nav-brand { grid-column: 2; text-align: center; }

            .nav-hamburger { display: flex; }

            .nav-actions .nav-link-item { display: none; }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-brand { font-size: 22px; }

            #back-to-top { bottom: 20px; right: 20px; }
        }

        @media (max-width: 480px) {
            .nav-inner { padding: 0 var(--spacing-xs); }
        }

        .pt-nav { padding-top: var(--nav-height); }

        .auren-alert {
            padding: 14px 20px;
            font-size: 13px;
            letter-spacing: 0.04em;
            border-left: 2px solid;
            margin-bottom: 24px;
        }

        .auren-alert.success {
            background: #f0fdf4;
            color: #166534;
            border-color: #166534;
        }

        .auren-alert.error {
            background: #fef2f2;
            color: #991b1b;
            border-color: #991b1b;
        }

        @yield('extra-css')
    </style>

    @stack('head-styles')
</head>

<body class="@yield('body-class')">

    {{-- ======================== PAGE LOADER ======================== --}}
    <div id="auren-loader" aria-hidden="true">
        <span class="loader-brand">♤ &nbsp;AUREN</span>
    </div>

    {{-- ======================== SCROLL PROGRESS ======================== --}}
    <div id="auren-progress" role="progressbar" aria-hidden="true"></div>

    {{-- ======================== NAVBAR ======================== --}}
    <header class="auren-nav @yield('nav-class', 'scrolled')" id="auren-header" role="banner">
        <div class="nav-inner">

            {{-- Left nav links --}}
            <ul class="nav-links-left">
                <li>
                    <a href="{{ route('products.index') }}"
                       class="nav-link-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        Sản phẩm
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/products') }}"
                       class="nav-link-item {{ request()->is('admin*') ? 'active' : '' }}">
                        Quản trị
                    </a>
                </li>
                {{-- Người 2 sẽ thêm route đăng nhập vào đây nếu cần --}}
            </ul>

            {{-- Brand / Logo --}}
            <a href="{{ route('products.index') }}" class="nav-brand" aria-label="AUREN — Trang chủ">
                <span class="brand-suit">♤</span> AUREN
            </a>

            {{-- Right actions --}}
            <div class="nav-actions">
                {{-- Search icon --}}
                <a href="{{ route('products.index', ['search' => '']) }}"
                   class="nav-icon-btn"
                   aria-label="Tìm kiếm">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </a>

                {{-- Cart icon — UI hook cho Người 3 (chỉ icon, không có cart logic) --}}
                <a href="{{ Route::has('cart.index') ? route('cart.index') : '#' }}"
                   class="nav-icon-btn"
                   aria-label="Giỏ hàng">
                    <svg viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </a>

                {{-- Account icon — UI hook cho Người 2 (chỉ icon, không có auth logic) --}}
                @if(Route::has('login'))
                    <a href="{{ auth()->check() ? (Route::has('profile.edit') ? route('profile.edit') : '#') : route('login') }}"
                       class="nav-icon-btn"
                       aria-label="Tài khoản">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </a>
                @else
                    <a href="{{ url('/login') }}" class="nav-icon-btn" aria-label="Tài khoản">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </a>
                @endif

                {{-- Hamburger for mobile --}}
                <button class="nav-hamburger" id="nav-hamburger" aria-label="Mở menu" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </header>

    {{-- ======================== MOBILE DRAWER ======================== --}}
    <nav class="mobile-drawer" id="mobile-drawer" aria-hidden="true" role="navigation">
        <ul class="mobile-nav-list">
            <li><a href="{{ route('products.index') }}" class="mobile-nav-link">Sản phẩm</a></li>
            <li><a href="{{ url('/admin/products') }}" class="mobile-nav-link">Quản trị</a></li>
            <li><a href="{{ url('/login') }}" class="mobile-nav-link">Đăng nhập</a></li>
            {{-- Người 2 có thể bổ sung thêm link vào đây --}}
        </ul>
    </nav>

    {{-- ======================== MAIN CONTENT ======================== --}}
    <main class="page-main" id="main-content">
        {{-- Flash messages from any controller --}}
        @if(session('success'))
            <div class="auren-container" style="padding-top: 24px;">
                <div class="auren-alert success" role="alert">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="auren-container" style="padding-top: 24px;">
                <div class="auren-alert error" role="alert">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- ======================== FOOTER ======================== --}}
    <footer class="auren-footer" role="contentinfo">
        <div class="footer-grid">
            {{-- Brand column --}}
            <div>
                <p class="footer-brand">♤ AUREN</p>
                <p class="footer-tagline">
                    Thời trang tối giản, chất liệu cao cấp.<br>
                    Thiết kế cho phiên bản tốt hơn của bạn.
                </p>
            </div>

            {{-- Explore --}}
            <div>
                <p class="footer-col-title">Khám phá</p>
                <ul class="footer-col-links">
                    <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                    <li><a href="{{ route('products.index', ['sort' => 'price_asc']) }}">Mới nhất</a></li>
                    <li><a href="{{ route('products.index', ['category' => '']) }}">Bộ sưu tập</a></li>
                </ul>
            </div>

            {{-- Service --}}
            <div>
                <p class="footer-col-title">Dịch vụ</p>
                <ul class="footer-col-links">
                    <li><a href="{{ url('/login') }}">Tài khoản</a></li>
                    <li><a href="{{ Route::has('cart.index') ? route('cart.index') : '#' }}">Giỏ hàng</a></li>
                    <li><a href="{{ Route::has('orders.index') ? route('orders.index') : '#' }}">Đơn hàng</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <p class="footer-col-title">Liên hệ</p>
                <ul class="footer-col-links">
                    <li><a href="mailto:hello@auren.vn">hello@auren.vn</a></li>
                    <li><a href="tel:+84901234567">+84 90 123 4567</a></li>
                    <li><a href="#">TP. Hồ Chí Minh, Việt Nam</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span class="footer-copy">
                © {{ date('Y') }} AUREN. All rights reserved.
            </span>
            <div class="footer-social">
                <a href="#">Instagram</a>
                <a href="#">Facebook</a>
                <a href="#">Pinterest</a>
            </div>
        </div>
    </footer>

    {{-- ======================== BACK TO TOP ======================== --}}
    <button id="back-to-top" aria-label="Quay lên đầu trang">
        <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
    </button>

    {{-- ======================== GLOBAL SCRIPTS ======================== --}}
    <script>
    (function () {
        'use strict';

        const loader = document.getElementById('auren-loader');
        if (loader) {
            const hideLoader = () => {
                setTimeout(() => loader.classList.add('loaded'), 600);
            };
            if (document.readyState === 'complete') {
                hideLoader();
            } else {
                window.addEventListener('load', hideLoader);
            }
        }

        const progressBar = document.getElementById('auren-progress');
        function updateProgress() {
            if (!progressBar) return;
            const scrolled = window.scrollY;
            const total = document.documentElement.scrollHeight - window.innerHeight;
            progressBar.style.width = total > 0 ? (scrolled / total * 100) + '%' : '0%';
        }

        const header = document.getElementById('auren-header');
        const NAV_TRANSPARENT_CLASS = 'transparent';
        const NAV_SCROLLED_CLASS = 'scrolled';

        // Only use transparent mode if view explicitly opts in
        const useTransparentNav = header && header.classList.contains(NAV_TRANSPARENT_CLASS);

        function handleNavScroll() {
            if (!header) return;
            const scrolled = window.scrollY > 40;
            if (useTransparentNav) {
                header.classList.toggle(NAV_SCROLLED_CLASS, scrolled);
                header.classList.toggle(NAV_TRANSPARENT_CLASS, !scrolled);
            }
        }

        const btt = document.getElementById('back-to-top');
        function handleBackToTop() {
            if (!btt) return;
            btt.classList.toggle('visible', window.scrollY > 400);
        }

        if (btt) {
            btt.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        let scrollTicking = false;
        window.addEventListener('scroll', () => {
            if (!scrollTicking) {
                requestAnimationFrame(() => {
                    updateProgress();
                    handleNavScroll();
                    handleBackToTop();
                    scrollTicking = false;
                });
                scrollTicking = true;
            }
        }, { passive: true });

        updateProgress();
        handleNavScroll();
        handleBackToTop();

        if ('IntersectionObserver' in window) {
            const revealEls = document.querySelectorAll(
                '.reveal, .reveal-up, .reveal-left, .reveal-right, .fade-in, .scale-in'
            );

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

            revealEls.forEach(el => revealObserver.observe(el));
        } else {
            document.querySelectorAll(
                '.reveal, .reveal-up, .reveal-left, .reveal-right, .fade-in, .scale-in'
            ).forEach(el => el.classList.add('is-visible'));
        }

        const hamburger = document.getElementById('nav-hamburger');
        const drawer = document.getElementById('mobile-drawer');
        let drawerOpen = false;

        function toggleDrawer(open) {
            drawerOpen = open;
            hamburger && hamburger.classList.toggle('open', open);
            hamburger && hamburger.setAttribute('aria-expanded', open ? 'true' : 'false');
            drawer && drawer.classList.toggle('open', open);
            drawer && drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
            document.body.style.overflow = open ? 'hidden' : '';
        }

        if (hamburger) {
            hamburger.addEventListener('click', () => toggleDrawer(!drawerOpen));
        }

        if (drawer) {
            drawer.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => toggleDrawer(false));
            });
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && drawerOpen) toggleDrawer(false);
        });

    })();
    </script>

    @stack('scripts')
</body>
</html>
