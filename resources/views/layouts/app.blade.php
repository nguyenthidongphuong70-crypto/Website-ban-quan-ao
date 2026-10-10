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
            --clr-black: #0a0a0a;
            --clr-white: #ffffff;
            --clr-ivory: #f8f5f0;
            --clr-offwhite: #f2ede8;
            --clr-beige: #e8e0d6;
            --clr-warm-gray: #a89f95;
            --clr-mid-gray: #6b6560;
            --clr-dark-gray: #2e2b28;

            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'DM Sans', -apple-system, sans-serif;

            --nav-height: 72px;
            --transition-base: 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-slow: 600ms cubic-bezier(0.25, 0.46, 0.45, 0.94);

            --spacing-xs: 8px;
            --spacing-sm: 16px;
            --spacing-md: 32px;
            --spacing-lg: 64px;
            --spacing-xl: 96px;
            --spacing-2xl: 128px;

            --max-width: 1280px;
        }

        *,
        *::before,
        *::after {
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

        img,
        video {
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
            0% {
                opacity: 0;
                transform: translateY(8px);
            }

            50% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
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

        .nav-brand:hover {
            opacity: 0.7;
        }

        .nav-brand .brand-suit {
            font-size: 14px;
            margin-right: 4px;
        }

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

        .nav-link-item:hover {
            opacity: 0.6;
        }

        .nav-link-item:hover::after,
        .nav-link-item.active::after {
            transform: scaleX(1);
        }

        .nav-link-item.active {
            opacity: 1;
        }

        .account-menu {
            position: relative;
        }

        .account-toggle {
            cursor: pointer;
        }

        .account-dropdown {
            position: absolute;
            top: 48px;
            right: 0;

            min-width: 190px;

            background: var(--clr-white);
            border: 1px solid var(--clr-beige);
            border-radius: 10px;

            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);

            padding: 8px 0;

            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);

            transition: all 0.2s ease;

            z-index: 2000;
        }

        .account-menu:hover .account-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .account-dropdown a,
        .account-dropdown button {
            width: 100%;

            display: block;

            padding: 11px 16px;

            border: none;
            background: transparent;

            color: var(--clr-black);

            text-align: left;
            text-decoration: none;

            font-family: var(--font-body);
            font-size: 13px;

            cursor: pointer;
        }

        .account-dropdown a:hover,
        .account-dropdown button:hover {
            background: var(--clr-offwhite);
        }

        .account-dropdown form {
            margin: 0;
        }

        .account-name {
            padding: 10px 16px;

            font-size: 12px;
            font-weight: 500;

            color: var(--clr-mid-gray);

            border-bottom: 1px solid var(--clr-beige);

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .badge-role-admin {
            display: inline-block;
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 2px 6px;
            border-radius: 4px;
            background: #111110;
            color: #c9a96e;
            margin-left: 6px;
            vertical-align: middle;
        }

        .account-admin-section {
            padding: 4px 0;
            border-bottom: 1px solid var(--clr-beige);
            background: rgba(201, 169, 110, 0.05);
        }

        .account-section-title {
            display: block;
            padding: 6px 16px 2px;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #c9a96e;
        }

        .admin-nav-dropdown-wrap {
            position: relative;
        }

        .admin-nav-dropdown {
            position: absolute;
            top: 28px;
            left: 0;
            min-width: 210px;
            background: var(--clr-white);
            border: 1px solid var(--clr-beige);
            border-radius: 10px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            padding: 6px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: all 0.2s ease;
            z-index: 2000;
        }

        .admin-nav-dropdown-wrap:hover .admin-nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .admin-nav-dropdown a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            font-size: 12px;
            color: var(--clr-black);
            text-decoration: none;
            transition: background var(--transition-base), color var(--transition-base);
            letter-spacing: 0.04em;
        }

        .admin-nav-dropdown a:hover,
        .admin-nav-dropdown a.active {
            background: var(--clr-offwhite);
            color: #c9a96e;
        }

        .admin-nav-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link-item.active::after {
            transform: scaleX(1);
        }

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

        .nav-icon-btn:hover {
            opacity: 0.6;
        }

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
            border-radius: 10px;
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

        .btn-auren:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        .btn-auren span {
            position: relative;
            z-index: 1;
        }

        .btn-dark {
            background: var(--clr-black);
            color: var(--clr-white);
            box-shadow: 0 2px 6px rgba(10, 10, 10, 0.12);
        }

        .btn-dark::before {
            background: var(--clr-dark-gray);
        }

        .btn-dark:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(10, 10, 10, 0.28);
        }

        .btn-outline {
            background: transparent;
            color: var(--clr-black);
            border: 1px solid var(--clr-black);
            border-radius: 10px;
        }

        .btn-outline::before {
            background: var(--clr-black);
        }

        .btn-outline:hover {
            color: var(--clr-white);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(10, 10, 10, 0.18);
        }

        .btn-ghost {
            background: transparent;
            color: var(--clr-black);
            border: 1px solid var(--clr-beige);
            border-radius: 8px;
            height: 40px;
            padding: 0 20px;
        }

        .btn-ghost::before {
            background: var(--clr-beige);
        }

        .btn-ghost:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .btn-glow-dark:hover {
            box-shadow: 0 6px 18px rgba(10, 10, 10, 0.3) !important;
            transform: translateY(-1px);
        }

        .btn-glow-blue:hover {
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35) !important;
            transform: translateY(-1px);
        }

        .btn-glow-danger:hover {
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.35) !important;
            transform: translateY(-1px);
        }

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

        .btn-arrow:hover::after {
            transform: scaleX(0);
            transform-origin: right;
        }

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
            border-radius: 10px;
            outline: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: border-color var(--transition-base), box-shadow var(--transition-base);
            -webkit-appearance: none;
            appearance: none;
        }

        .auren-input:focus {
            border-color: var(--clr-black);
            box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.08);
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
            border-radius: 10px;
            outline: none;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            -webkit-appearance: none;
            appearance: none;
            transition: border-color var(--transition-base), box-shadow var(--transition-base);
        }

        .auren-select:focus {
            border-color: var(--clr-black);
            box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.08);
        }

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

            .reveal-up {
                transform: translateY(30px);
            }

            .reveal-left {
                transform: translateX(-30px);
            }

            .reveal-right {
                transform: translateX(30px);
            }

            .scale-in {
                transform: scale(0.96);
            }

            .fade-in {}

            .reveal.is-visible,
            .reveal-up.is-visible,
            .reveal-left.is-visible,
            .reveal-right.is-visible,
            .fade-in.is-visible,
            .scale-in.is-visible {
                opacity: 1;
                transform: none;
            }

            .reveal-delay-1 {
                transition-delay: 0.1s;
            }

            .reveal-delay-2 {
                transition-delay: 0.2s;
            }

            .reveal-delay-3 {
                transition-delay: 0.3s;
            }

            .reveal-delay-4 {
                transition-delay: 0.4s;
            }

            .reveal-delay-5 {
                transition-delay: 0.5s;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .reveal,
            .reveal-up,
            .reveal-left,
            .reveal-right,
            .fade-in,
            .scale-in {
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
            color: rgba(255, 255, 255, 0.75);
            transition: color var(--transition-base);
        }

        .footer-col-links a:hover {
            color: var(--clr-white);
        }

        .footer-bottom {
            max-width: var(--max-width);
            margin: var(--spacing-lg) auto 0;
            padding: var(--spacing-sm) var(--spacing-md) 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.35);
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
            color: rgba(255, 255, 255, 0.5);
            transition: color var(--transition-base);
        }

        .footer-social a:hover {
            color: var(--clr-white);
        }

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

            .nav-links-left {
                display: none;
            }

            .nav-inner {
                grid-template-columns: auto 1fr auto;
                padding: 0 var(--spacing-md);
            }

            .nav-brand {
                grid-column: 2;
                text-align: center;
            }

            .nav-hamburger {
                display: flex;
            }

            .nav-actions .nav-link-item {
                display: none;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-brand {
                font-size: 22px;
            }

            #back-to-top {
                bottom: 20px;
                right: 20px;
            }
        }

        @media (max-width: 480px) {
            .nav-inner {
                padding: 0 var(--spacing-xs);
            }
        }

        .pt-nav {
            padding-top: var(--nav-height);
        }

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

        /* ======================== SEARCH OVERLAY & AUTOCOMPLETE ======================== */
        #auren-search-overlay {
            position: fixed;
            top: var(--nav-height);
            left: 0;
            width: 100%;
            background: rgba(248, 245, 240, 0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--clr-beige);
            box-shadow: 0 16px 32px rgba(10, 10, 10, 0.06);
            z-index: 990;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: opacity var(--transition-base), transform var(--transition-base), visibility var(--transition-base);
        }

        #auren-search-overlay.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .auren-search-inner {
            max-width: 800px;
            margin: 0 auto;
            padding: 16px 20px 20px;
            position: relative;
        }

        .auren-search-input-wrap {
            display: flex;
            align-items: center;
            background: var(--clr-white);
            border: 1px solid var(--clr-beige);
            border-radius: 999px;
            padding: 4px 6px 4px 16px;
            transition: border-color var(--transition-base), box-shadow var(--transition-base);
            box-shadow: 0 2px 8px rgba(10, 10, 10, 0.03);
        }

        .auren-search-input-wrap:focus-within {
            border-color: var(--clr-black);
            box-shadow: 0 4px 16px rgba(10, 10, 10, 0.08);
        }

        .auren-search-icon-sm {
            width: 18px;
            height: 18px;
            stroke: var(--clr-mid-gray);
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
            margin-right: 10px;
        }

        #auren-search-input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-family: var(--font-body);
            font-size: 15px;
            color: var(--clr-black);
            padding: 8px 4px;
        }

        #auren-search-input::placeholder {
            color: var(--clr-warm-gray);
            font-weight: 300;
        }

        .auren-search-btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: var(--clr-offwhite);
            color: var(--clr-dark-gray);
            margin: 0 4px;
            cursor: pointer;
            transition: background var(--transition-base);
            flex-shrink: 0;
        }

        .auren-search-btn-icon:hover {
            background: var(--clr-beige);
        }

        .auren-search-btn-icon svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .auren-search-btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--clr-black);
            color: var(--clr-white);
            border: none;
            border-radius: 999px;
            padding: 8px 18px;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: background var(--transition-base), transform var(--transition-base);
            flex-shrink: 0;
            margin-left: 4px;
        }

        .auren-search-btn-submit:hover {
            background: var(--clr-dark-gray);
        }

        .auren-search-btn-submit svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .auren-search-btn-close {
            background: transparent;
            border: none;
            color: var(--clr-mid-gray);
            font-family: var(--font-body);
            font-size: 13px;
            padding: 8px 12px;
            cursor: pointer;
            transition: color var(--transition-base);
            flex-shrink: 0;
        }

        .auren-search-btn-close:hover {
            color: var(--clr-black);
        }

        #auren-search-suggestions {
            list-style: none;
            margin: 12px 0 0;
            padding: 8px;
            background: var(--clr-white);
            border: 1px solid var(--clr-beige);
            border-radius: 14px;
            max-height: 380px;
            overflow-y: auto;
            box-shadow: 0 10px 24px rgba(10, 10, 10, 0.05);
            display: none;
        }

        #auren-search-suggestions.has-items {
            display: block;
        }

        .auren-search-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            transition: background var(--transition-base);
        }

        .auren-search-item:hover,
        .auren-search-item.is-selected {
            background: var(--clr-ivory);
        }

        .auren-search-item-thumb {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            background: var(--clr-offwhite);
            flex-shrink: 0;
        }

        .auren-search-item-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .auren-search-item-name {
            font-size: 14px;
            font-weight: 400;
            color: var(--clr-black);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .auren-search-item-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }

        .auren-search-item-price {
            font-weight: 500;
            color: var(--clr-black);
        }

        .auren-search-item-cat {
            color: var(--clr-warm-gray);
        }

        .auren-search-item-badge {
            font-size: 11px;
            color: var(--clr-warm-gray);
            margin-left: auto;
            flex-shrink: 0;
        }

        .auren-search-empty {
            padding: 24px 16px;
            text-align: center;
            color: var(--clr-mid-gray);
            font-size: 14px;
        }

        .auren-search-empty p {
            margin-bottom: 6px;
        }

        .auren-search-view-all {
            display: block;
            text-align: center;
            padding: 10px;
            margin-top: 6px;
            border-top: 1px dashed var(--clr-beige);
            font-size: 13px;
            font-weight: 500;
            color: var(--clr-black);
            cursor: pointer;
            border-radius: 6px;
            transition: background var(--transition-base);
        }

        .auren-search-view-all:hover {
            background: var(--clr-ivory);
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .auren-search-inner {
                padding: 12px 14px;
            }
            .auren-search-btn-text {
                display: none;
            }
            .auren-search-btn-submit {
                padding: 8px 12px;
            }
            .auren-search-btn-close {
                padding: 8px 6px;
            }
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
                        class="nav-link-item {{ request()->routeIs('products.index') && !request()->has('view') && !request()->filled('category') && !request()->filled('search') && !request()->filled('sort') && !request()->filled('size') && !request()->filled('min_price') && !request()->filled('max_price') && !request()->is('admin*') ? 'active' : '' }}">
                        Trang chủ
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index', ['view' => 'all']) }}"
                        class="nav-link-item {{ request()->routeIs('products.index') && (request()->has('view') || request()->filled('category') || request()->filled('search') || request()->filled('sort') || request()->filled('size') || request()->filled('min_price') || request()->filled('max_price')) && !request()->is('admin*') ? 'active' : '' }}">
                        Tất cả sản phẩm
                    </a>
                </li>

                {{-- Khu vực chức năng Admin — Chỉ Admin mới nhìn thấy --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="admin-nav-dropdown-wrap">
                            <a href="{{ route('admin.products.index') }}"
                                class="nav-link-item admin-nav-badge {{ request()->is('admin*') ? 'active' : '' }}">
                                Quản trị <span style="font-size: 8px; margin-left: 2px;">▼</span>
                            </a>
                            <div class="admin-nav-dropdown">
                                @if(Route::has('admin.dashboard'))
                                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                        📊 Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('admin.products.index') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                                    👕 Quản lý sản phẩm
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                                    📁 Quản lý danh mục
                                </a>
                                @if(Route::has('admin.orders.index'))
                                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                                        📦 Quản lý đơn hàng
                                    </a>
                                @elseif(Route::has('admin.orders'))
                                    <a href="{{ route('admin.orders') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                                        📦 Quản lý đơn hàng
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- Brand / Logo --}}
            <a href="{{ route('products.index') }}" class="nav-brand" aria-label="AUREN — Trang chủ">
                <span class="brand-suit">♤</span> AUREN
            </a>

            {{-- Right actions --}}
            <div class="nav-actions">
                {{-- Search icon --}}
                <button type="button"
                    id="auren-search-toggle"
                    class="nav-icon-btn"
                    aria-label="Tìm kiếm"
                    aria-expanded="false"
                    aria-controls="auren-search-overlay">
                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                </button>

                {{-- Cart icon — UI hook cho Người 3 (chỉ icon, không có cart logic) --}}
                <a href="{{ Route::has('cart.index') ? route('cart.index') : '#' }}"
                    class="nav-icon-btn"
                    aria-label="Giỏ hàng">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                </a>

                {{-- Account icon — Người 2 --}}
                <div class="account-menu">

                    <button type="button"
                        class="nav-icon-btn account-toggle"
                        aria-label="Tài khoản">

                        <svg viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>

                    </button>

                    <div class="account-dropdown">

                        @guest

                        <a href="{{ route('login') }}">
                            Đăng nhập
                        </a>

                        <a href="{{ route('register') }}">
                            Đăng ký
                        </a>

                        @endguest

                        @auth

                        <div class="account-name">
                            <span>{{ auth()->user()->full_name }}</span>
                            @if(auth()->user()->isAdmin())
                                <span class="badge-role-admin">Admin</span>
                            @endif
                        </div>

                        {{-- Menu quản trị nhanh dành riêng cho Admin trong Account Dropdown --}}
                        @if(auth()->user()->isAdmin())
                            <div class="account-admin-section">
                                <span class="account-section-title">Quản trị hệ thống</span>
                                @if(Route::has('admin.dashboard'))
                                    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                                @endif
                                <a href="{{ route('admin.products.index') }}">👕 Quản lý sản phẩm</a>
                                <a href="{{ route('admin.categories.index') }}">📁 Quản lý danh mục</a>
                                @if(Route::has('admin.orders.index'))
                                    <a href="{{ route('admin.orders.index') }}">📦 Quản lý đơn hàng</a>
                                @elseif(Route::has('admin.orders'))
                                    <a href="{{ route('admin.orders') }}">📦 Quản lý đơn hàng</a>
                                @endif
                            </div>
                        @endif

                        <a href="{{ route('profile.edit') }}">
                            Thông tin cá nhân
                        </a>
                        <a href="{{ route('profile.password.edit') }}">
                            Đổi mật khẩu
                        </a>

                        <form action="{{ route('logout') }}"
                            method="POST">

                            @csrf

                            <button type="submit">
                                Đăng xuất
                            </button>

                        </form>

                        @endauth

                    </div>

                </div>

                {{-- Hamburger for mobile --}}
                <button class="nav-hamburger" id="nav-hamburger" aria-label="Mở menu" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </header>

    {{-- ======================== SEARCH OVERLAY ======================== --}}
    {{-- Embed product data for client-side autocomplete --}}
    @php
        try {
            $headerSearchProducts = \App\Models\Product::select('id','name','price','image','category_id')
                ->with('category:id,name')
                ->get()
                ->map(fn($p) => [
                    'id'        => $p->id,
                    'name'      => $p->name,
                    'price_raw' => (int)$p->price,
                    'price'     => number_format((float)$p->price, 0, ',', '.') . '₫',
                    'image_url' => method_exists($p, 'getImageUrlAttribute') ? $p->image_url : ($p->image ?? ''),
                    'category'  => $p->category?->name ?? '',
                ]);
        } catch (\Throwable $e) {
            $headerSearchProducts = collect([]);
        }
    @endphp
    <script>
        window.AUREN_PRODUCTS = @json($headerSearchProducts);
        window.AUREN_SEARCH_URL = '{{ route('products.index') }}';
    </script>

    <div id="auren-search-overlay" role="search" aria-hidden="true" aria-label="Tìm kiếm sản phẩm">
        <div class="auren-search-inner">
            <div class="auren-search-input-wrap">
                <svg class="auren-search-icon-sm" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input
                    type="text"
                    id="auren-search-input"
                    placeholder="Tìm kiếm sản phẩm..."
                    autocomplete="off"
                    spellcheck="false"
                    aria-autocomplete="list"
                    aria-controls="auren-search-suggestions"
                    aria-activedescendant=""
                >
                <button type="button" id="auren-search-clear" class="auren-search-btn-icon" aria-label="Xóa từ khóa" hidden>
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
                <button type="button" id="auren-search-submit" class="auren-search-btn-submit" aria-label="Tìm kiếm">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <span class="auren-search-btn-text">Tìm</span>
                </button>
                <button type="button" id="auren-search-close" class="auren-search-btn-close" aria-label="Đóng tìm kiếm">
                    Đóng
                </button>
            </div>
            <ul id="auren-search-suggestions" role="listbox" aria-label="Gợi ý sản phẩm"></ul>
        </div>
    </div>

    {{-- ======================== MOBILE DRAWER ======================== --}}
    <nav class="mobile-drawer" id="mobile-drawer" aria-hidden="true" role="navigation">
        <ul class="mobile-nav-list">
            <li><a href="{{ route('products.index') }}" class="mobile-nav-link">Trang chủ</a></li>
            <li><a href="{{ route('products.index', ['view' => 'all']) }}" class="mobile-nav-link">Tất cả sản phẩm</a></li>

            {{-- Chỉ Admin mới thấy menu quản trị trên mobile --}}
            @auth
                @if(auth()->user()->isAdmin())
                    <li style="margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--clr-beige);">
                        <span style="font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--clr-warm-gray); display: block; margin-bottom: 8px;">Quản trị (Admin)</span>
                    </li>
                    @if(Route::has('admin.dashboard'))
                        <li><a href="{{ route('admin.dashboard') }}" class="mobile-nav-link" style="font-size: 18px;">📊 Dashboard</a></li>
                    @endif
                    <li><a href="{{ route('admin.products.index') }}" class="mobile-nav-link" style="font-size: 18px;">👕 Quản lý sản phẩm</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="mobile-nav-link" style="font-size: 18px;">📁 Quản lý danh mục</a></li>
                    @if(Route::has('admin.orders.index'))
                        <li><a href="{{ route('admin.orders.index') }}" class="mobile-nav-link" style="font-size: 18px;">📦 Quản lý đơn hàng</a></li>
                    @elseif(Route::has('admin.orders'))
                        <li><a href="{{ route('admin.orders') }}" class="mobile-nav-link" style="font-size: 18px;">📦 Quản lý đơn hàng</a></li>
                    @endif
                @endif
            @endauth

            @guest
                <li><a href="{{ route('login') }}" class="mobile-nav-link">Đăng nhập</a></li>
                <li><a href="{{ route('register') }}" class="mobile-nav-link">Đăng ký</a></li>
            @endguest
            @auth
                <li><a href="{{ route('profile.edit') }}" class="mobile-nav-link">Tài khoản</a></li>
            @endauth
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

            {{-- Contact & Map --}}
            <div>
                <p class="footer-col-title">Liên hệ</p>
                <ul class="footer-col-links" style="margin-bottom: 16px;">
                    <li><a href="mailto:hello@auren.vn">hello@auren.vn</a></li>
                    <li><a href="tel:+84901234567">+84 90 123 4567</a></li>
                    <li><span>TP. Hồ Chí Minh, Việt Nam</span></li>
                </ul>
            </div>
        </div>

        {{-- Google Maps Embed Responsive --}}
        <div style="max-width: var(--max-width); margin: 36px auto 0; padding: 0 var(--spacing-md);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                <span style="font-size: 10px; font-weight: 400; letter-spacing: 0.2em; text-transform: uppercase; color: var(--clr-warm-gray);">Bản đồ khu vực</span>
                <span style="font-size: 11px; color: rgba(255,255,255,0.4);">TP. Hồ Chí Minh</span>
            </div>
            <div style="width: 100%; height: 160px; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125410.74805721114!2d106.60838183182875!3d10.775843916961445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529292e42c671%3A0x9c42630a618f8e12!2zVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1710000000000!5m2!1svi!2s"
                    width="100%"
                    height="100%"
                    style="border:0; filter: invert(90%) hue-rotate(180deg) brightness(90%) contrast(90%);"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Bản đồ AUREN - TP. Hồ Chí Minh"></iframe>
            </div>
        </div>

        <div class="footer-bottom">
            <span class="footer-copy">
                © {{ date('Y') }} AUREN. All rights reserved.
            </span>
            <div class="footer-social">
                <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">Facebook</a>
                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">Instagram</a>
                <a href="https://www.pinterest.com/" target="_blank" rel="noopener noreferrer">Pinterest</a>
            </div>
        </div>
    </footer>

    {{-- ======================== BACK TO TOP ======================== --}}
    <button id="back-to-top" aria-label="Quay lên đầu trang">
        <svg viewBox="0 0 24 24">
            <polyline points="18 15 12 9 6 15" />
        </svg>
    </button>

    {{-- ======================== GLOBAL SCRIPTS ======================== --}}
    <script>
        (function() {
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
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
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
            }, {
                passive: true
            });

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
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -40px 0px'
                });

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

            // ======================== AUREN HEADER SEARCH LOGIC ========================
            const searchToggle = document.getElementById('auren-search-toggle');
            const searchOverlay = document.getElementById('auren-search-overlay');
            const searchInput = document.getElementById('auren-search-input');
            const searchClear = document.getElementById('auren-search-clear');
            const searchSubmit = document.getElementById('auren-search-submit');
            const searchClose = document.getElementById('auren-search-close');
            const searchSuggestions = document.getElementById('auren-search-suggestions');
            const productsList = Array.isArray(window.AUREN_PRODUCTS) ? window.AUREN_PRODUCTS : [];
            const searchBaseUrl = window.AUREN_SEARCH_URL || '/products';

            let selectedIndex = -1;
            let debounceTimer = null;

            function removeVietnameseTones(str) {
                if (!str) return '';
                return str
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/đ/g, 'd')
                    .replace(/Đ/g, 'D')
                    .toLowerCase()
                    .trim();
            }

            function escapeHtml(str) {
                if (!str) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function openSearch() {
                if (!searchOverlay) return;
                searchOverlay.classList.add('is-active');
                searchOverlay.setAttribute('aria-hidden', 'false');
                searchToggle && searchToggle.setAttribute('aria-expanded', 'true');
                setTimeout(() => {
                    searchInput && searchInput.focus();
                }, 100);
            }

            function closeSearch() {
                if (!searchOverlay) return;
                searchOverlay.classList.remove('is-active');
                searchOverlay.setAttribute('aria-hidden', 'true');
                searchToggle && searchToggle.setAttribute('aria-expanded', 'false');
                clearSuggestions();
                selectedIndex = -1;
            }

            function clearSuggestions() {
                if (!searchSuggestions) return;
                searchSuggestions.innerHTML = '';
                searchSuggestions.classList.remove('has-items');
                selectedIndex = -1;
            }

            function executeSearch(query) {
                const term = (query !== undefined ? query : (searchInput ? searchInput.value : '')).trim();
                const url = new URL(searchBaseUrl, window.location.origin);
                url.searchParams.set('view', 'all');
                if (term) {
                    url.searchParams.set('search', term);
                }
                window.location.href = url.toString();
            }

            function renderSuggestions(query) {
                if (!searchSuggestions) return;
                const cleanQuery = removeVietnameseTones(query);
                if (!cleanQuery) {
                    clearSuggestions();
                    return;
                }

                const matches = productsList.filter(p => {
                    const cleanName = removeVietnameseTones(p.name);
                    const cleanCategory = removeVietnameseTones(p.category);
                    return cleanName.includes(cleanQuery) || cleanCategory.includes(cleanQuery);
                }).slice(0, 6);

                searchSuggestions.innerHTML = '';
                selectedIndex = -1;

                if (matches.length === 0) {
                    const emptyItem = document.createElement('li');
                    emptyItem.className = 'auren-search-empty';
                    emptyItem.innerHTML = `<p>Không tìm thấy sản phẩm nào khớp với <strong>"${escapeHtml(query)}"</strong></p><span style="font-size:12px;color:var(--clr-warm-gray);">Nhấn Enter để tìm kiếm trên toàn bộ danh mục</span>`;
                    searchSuggestions.appendChild(emptyItem);
                } else {
                    matches.forEach((item, index) => {
                        const li = document.createElement('li');
                        li.setAttribute('role', 'option');
                        li.id = 'search-item-' + index;

                        const a = document.createElement('a');
                        a.className = 'auren-search-item';
                        const itemUrl = new URL(searchBaseUrl, window.location.origin);
                        itemUrl.searchParams.set('view', 'all');
                        itemUrl.searchParams.set('search', item.name);
                        a.href = itemUrl.toString();

                        const img = document.createElement('img');
                        img.className = 'auren-search-item-thumb';
                        img.src = item.image_url || '/placeholder.png';
                        img.alt = item.name;
                        img.loading = 'lazy';
                        img.onerror = () => { img.src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2248%22%20height%3D%2248%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f2ede8%22%2F%3E%3C%2Fsvg%3E'; };

                        const info = document.createElement('div');
                        info.className = 'auren-search-item-info';

                        const nameSpan = document.createElement('span');
                        nameSpan.className = 'auren-search-item-name';
                        nameSpan.textContent = item.name;

                        const meta = document.createElement('div');
                        meta.className = 'auren-search-item-meta';

                        const priceSpan = document.createElement('span');
                        priceSpan.className = 'auren-search-item-price';
                        priceSpan.textContent = item.price;

                        meta.appendChild(priceSpan);
                        if (item.category) {
                            const catSpan = document.createElement('span');
                            catSpan.className = 'auren-search-item-cat';
                            catSpan.textContent = '• ' + item.category;
                            meta.appendChild(catSpan);
                        }

                        info.appendChild(nameSpan);
                        info.appendChild(meta);

                        const badge = document.createElement('span');
                        badge.className = 'auren-search-item-badge';
                        badge.textContent = 'Xem →';

                        a.appendChild(img);
                        a.appendChild(info);
                        a.appendChild(badge);

                        a.addEventListener('click', (e) => {
                            e.preventDefault();
                            executeSearch(item.name);
                        });

                        li.appendChild(a);
                        searchSuggestions.appendChild(li);
                    });

                    // Add "Xem tất cả kết quả" option at bottom
                    const viewAllLi = document.createElement('li');
                    const viewAllBtn = document.createElement('a');
                    viewAllBtn.className = 'auren-search-view-all';
                    viewAllBtn.textContent = `Xem tất cả kết quả cho "${query}" →`;
                    viewAllBtn.href = '#';
                    viewAllBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        executeSearch(query);
                    });
                    viewAllLi.appendChild(viewAllBtn);
                    searchSuggestions.appendChild(viewAllLi);
                }

                searchSuggestions.classList.add('has-items');
            }

            if (searchToggle) {
                searchToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = searchOverlay && searchOverlay.classList.contains('is-active');
                    if (isOpen) {
                        closeSearch();
                    } else {
                        openSearch();
                    }
                });
            }

            if (searchClose) {
                searchClose.addEventListener('click', closeSearch);
            }

            if (searchInput) {
                searchInput.addEventListener('input', () => {
                    const val = searchInput.value;
                    if (searchClear) {
                        searchClear.hidden = val.trim().length === 0;
                    }
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        renderSuggestions(val);
                    }, 250);
                });

                searchInput.addEventListener('keydown', (e) => {
                    const items = searchSuggestions ? searchSuggestions.querySelectorAll('.auren-search-item') : [];
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (items.length > 0) {
                            selectedIndex = (selectedIndex + 1) % items.length;
                            updateActiveDescendant(items);
                        }
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (items.length > 0) {
                            selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                            updateActiveDescendant(items);
                        }
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (selectedIndex >= 0 && items[selectedIndex]) {
                            items[selectedIndex].click();
                        } else {
                            executeSearch();
                        }
                    } else if (e.key === 'Escape') {
                        closeSearch();
                    }
                });
            }

            function updateActiveDescendant(items) {
                items.forEach((item, idx) => {
                    if (idx === selectedIndex) {
                        item.classList.add('is-selected');
                        item.scrollIntoView({ block: 'nearest' });
                    } else {
                        item.classList.remove('is-selected');
                    }
                });
            }

            if (searchClear) {
                searchClear.addEventListener('click', () => {
                    if (searchInput) {
                        searchInput.value = '';
                        searchInput.focus();
                    }
                    searchClear.hidden = true;
                    clearSuggestions();
                });
            }

            if (searchSubmit) {
                searchSubmit.addEventListener('click', () => {
                    executeSearch();
                });
            }

            // Click outside to close search overlay
            document.addEventListener('click', (e) => {
                if (searchOverlay && searchOverlay.classList.contains('is-active')) {
                    if (!searchOverlay.contains(e.target) && !searchToggle.contains(e.target)) {
                        closeSearch();
                    }
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('is-active')) {
                    closeSearch();
                }
            });

        })();
    </script>

    @stack('scripts')
</body>

</html>