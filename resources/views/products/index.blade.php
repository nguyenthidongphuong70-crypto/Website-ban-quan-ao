@extends('layouts.app')

@php
    // Xác định xem người dùng đang ở Trang chủ hay Trang xem tất cả sản phẩm
    $isListing = request()->has('view')
        || request()->filled('category')
        || request()->filled('search')
        || request()->filled('sort')
        || request()->filled('size')
        || request()->filled('min_price')
        || request()->filled('max_price')
        || request()->filled('page');

    $selectedCategory = request('category') ? $categories->firstWhere('id', request('category')) : null;
@endphp

@section('title', $isListing ? ($selectedCategory ? $selectedCategory->name . ' — Bộ sưu tập' : 'Tất cả sản phẩm — AUREN') : 'AUREN — Thương hiệu thời trang cao cấp')

@section('extra-css')
<style>
/* ==========================================================================
   AUREN & TORANO-INSPIRED STYLES
   ========================================================================== */

/* -------------------- CAROUSEL TRANG CHỦ (~70% desktop) -------------------- */
.homepage-carousel-wrapper {
    width: 72%;
    max-width: 1180px;
    margin: 28px auto 44px;
    padding: 0 16px;
}

.auren-carousel {
    position: relative;
    width: 100%;
    aspect-ratio: 1344 / 768;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 12px 32px rgba(10, 10, 10, 0.08);
    background: var(--clr-offwhite);
}

.carousel-track {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform 0.65s cubic-bezier(0.25, 1, 0.5, 1);
}

.carousel-slide {
    position: relative;
    flex: 0 0 100%;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    display: block;
    user-select: none;
    -webkit-user-drag: none;
}

.carousel-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.45) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 32px 40px;
    color: #ffffff;
    pointer-events: none;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
}

.carousel-tagline {
    font-size: 11px;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 6px;
}

.carousel-title {
    font-family: var(--font-display);
    font-size: clamp(20px, 3.2vw, 36px);
    font-weight: 300;
    letter-spacing: 0.03em;
    color: #ffffff;
    line-height: 1.25;
}

.carousel-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    color: var(--clr-black);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
}

.carousel-nav-btn:hover {
    background: #ffffff;
    transform: translateY(-50%) scale(1.06);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.carousel-nav-btn.prev { left: 16px; }
.carousel-nav-btn.next { right: 16px; }

.carousel-nav-btn svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
}

.carousel-dots {
    position: absolute;
    bottom: 16px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}

.carousel-dot {
    width: 20px;
    height: 3px;
    border-radius: 2px;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.carousel-dot.active {
    width: 36px;
    background: #ffffff;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
}

/* -------------------- CAM KẾT DỊCH VỤ TORANO-STYLE -------------------- */
.service-commitments {
    max-width: var(--max-width);
    margin: 0 auto 50px;
    padding: 0 var(--spacing-md);
}

.service-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 16px;
    padding: 24px 28px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
}

.service-item {
    display: flex;
    align-items: center;
    gap: 16px;
}

.service-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--clr-offwhite);
    border: 1px solid var(--clr-beige);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--clr-black);
    transition: all 0.25s ease;
}

.service-item:hover .service-icon {
    background: var(--clr-black);
    color: var(--clr-white);
    transform: translateY(-2px);
}

.service-icon svg {
    width: 20px;
    height: 20px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.6;
}

.service-text h4 {
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.04em;
    color: var(--clr-black);
    margin-bottom: 2px;
}

.service-text p {
    font-size: 11px;
    color: var(--clr-warm-gray);
    line-height: 1.4;
    margin: 0;
}

/* -------------------- HOMEPAGE BRAND INTRO -------------------- */
.home-intro-banner {
    max-width: var(--max-width);
    margin: 0 auto 60px;
    padding: 0 var(--spacing-md);
    text-align: center;
}

.intro-content-box {
    background: linear-gradient(180deg, var(--clr-white) 0%, var(--clr-offwhite) 100%);
    border: 1px solid var(--clr-beige);
    border-radius: 18px;
    padding: 40px 24px;
}

.intro-brand-tag {
    font-size: 11px;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    margin-bottom: 10px;
}

.intro-heading {
    font-family: var(--font-display);
    font-size: clamp(22px, 3.2vw, 34px);
    font-weight: 300;
    color: var(--clr-black);
    margin-bottom: 12px;
    letter-spacing: -0.01em;
}

.intro-desc {
    font-size: 13px;
    color: var(--clr-mid-gray);
    max-width: 620px;
    margin: 0 auto 20px;
    line-height: 1.7;
}

.btn-explore-collection {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    font-weight: 500;
    color: var(--clr-black);
    padding: 10px 22px;
    border: 1px solid var(--clr-black);
    border-radius: 30px;
    background: transparent;
    text-decoration: none;
    transition: all 0.25s ease;
}

.btn-explore-collection:hover {
    background: var(--clr-black);
    color: var(--clr-white);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(10, 10, 10, 0.2);
}

/* -------------------- HOMEPAGE CATEGORY SECTIONS -------------------- */
.home-category-section {
    max-width: var(--max-width);
    margin: 0 auto 70px;
    padding: 0 var(--spacing-md);
}

.section-head-bar {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 24px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--clr-beige);
}

.section-title-wrap h3 {
    font-family: var(--font-display);
    font-size: clamp(22px, 2.8vw, 30px);
    font-weight: 400;
    color: var(--clr-black);
    letter-spacing: 0.02em;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.section-title-wrap p {
    font-size: 12px;
    color: var(--clr-warm-gray);
    letter-spacing: 0.05em;
    margin: 0;
}

.section-view-all-link {
    font-size: 11px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--clr-black);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
    padding-bottom: 2px;
    border-bottom: 1px solid transparent;
}

.section-view-all-link:hover {
    border-bottom-color: var(--clr-black);
    opacity: 0.7;
    transform: translateX(2px);
}

.section-bottom-action {
    text-align: center;
    margin-top: 32px;
}

.btn-see-more-category {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 32px;
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 30px;
    color: var(--clr-black);
    font-size: 11px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-weight: 500;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    transition: all 0.25s ease;
}

.btn-see-more-category:hover {
    background: var(--clr-black);
    border-color: var(--clr-black);
    color: var(--clr-white);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(10, 10, 10, 0.18);
}

/* -------------------- PRODUCT CARD (DÙNG CHUNG) -------------------- */
.products-grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px 20px;
}

.product-card-auren {
    display: flex;
    flex-direction: column;
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 14px;
    overflow: hidden;
    padding: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                box-shadow 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
}

.product-card-auren:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.09);
}

.product-img-wrap {
    position: relative;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: var(--clr-offwhite);
    border-radius: 10px;
    margin-bottom: 12px;
}

.product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.product-card-auren:hover .product-img-wrap img {
    transform: scale(1.05);
}

.product-cat-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    font-size: 9px;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--clr-white);
    background: rgba(10, 10, 10, 0.82);
    backdrop-filter: blur(4px);
    padding: 3px 8px;
    border-radius: 6px;
    z-index: 2;
}

.btn-eye-quickview {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    color: var(--clr-black);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    opacity: 0.85;
    transition: all 0.25s ease;
    z-index: 5;
}

.product-card-auren:hover .btn-eye-quickview {
    opacity: 1;
    transform: scale(1.05);
}

.btn-eye-quickview:hover {
    background: var(--clr-black) !important;
    color: var(--clr-white) !important;
    box-shadow: 0 4px 14px rgba(10, 10, 10, 0.3);
    transform: scale(1.12) !important;
}

.btn-eye-quickview svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.6;
}

.product-sold-out-badge {
    position: absolute;
    inset: 0;
    background: rgba(248, 245, 240, 0.75);
    backdrop-filter: blur(2px);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    z-index: 3;
}

.product-sold-out-text {
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--clr-mid-gray);
    background: var(--clr-ivory);
    padding: 6px 14px;
    border: 1px solid var(--clr-beige);
    border-radius: 6px;
}

.product-info-auren {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    padding: 2px 4px 6px;
}

.product-name-auren {
    font-family: var(--font-display);
    font-size: 16px;
    font-weight: 400;
    line-height: 1.35;
    color: var(--clr-black);
    margin-bottom: 4px;
    text-decoration: none;
    transition: opacity 0.2s ease;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 42px;
}

.product-name-auren:hover {
    opacity: 0.65;
}

.product-sub-auren {
    font-size: 11px;
    color: var(--clr-warm-gray);
    letter-spacing: 0.04em;
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-price-row-auren {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 8px;
    border-top: 1px solid var(--clr-beige);
    margin-bottom: 10px;
}

.product-price-auren {
    font-family: var(--font-display);
    font-size: 17px;
    font-weight: 500;
    color: var(--clr-black);
}

.product-stock-auren {
    font-size: 10px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
}

/* NÚT MUA NGAY TRÊN CARD */
.btn-card-buy-now {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    height: 38px;
    background: var(--clr-black);
    color: var(--clr-white);
    border: 1px solid var(--clr-black);
    border-radius: 8px;
    font-size: 11px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-weight: 400;
    text-decoration: none;
    transition: all 0.25s ease;
    cursor: pointer;
}

.btn-card-buy-now:hover {
    background: var(--clr-white);
    color: var(--clr-black);
    box-shadow: 0 4px 12px rgba(10, 10, 10, 0.15);
}

.btn-card-buy-now svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
}

.btn-card-buy-now.sold-out {
    background: var(--clr-offwhite);
    color: var(--clr-warm-gray);
    border-color: var(--clr-beige);
    pointer-events: none;
}

/* ==========================================================================
   LISTING / SHOP PAGE (BỐ CỤC 2 CỘT CHUẨN TORANO + 2 ẢNH ĐÍNH KÈM)
   ========================================================================== */
.listing-page-wrapper {
    max-width: var(--max-width);
    margin: 0 auto 80px;
    padding: 0 var(--spacing-md);
}

/* Breadcrumb */
.listing-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    margin: 20px 0 24px;
}

.listing-breadcrumb a {
    color: var(--clr-warm-gray);
    text-decoration: none;
    transition: color 0.2s ease;
}

.listing-breadcrumb a:hover {
    color: var(--clr-black);
}

.listing-breadcrumb .sep {
    font-size: 10px;
    color: var(--clr-beige);
}

.listing-breadcrumb .current {
    color: var(--clr-black);
    font-weight: 500;
}

/* Main 2-Column Grid */
.listing-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 36px;
    align-items: start;
}

/* -------------------- SIDEBAR FILTER (THEO 2 ẢNH) -------------------- */
.filter-sidebar {
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 16px;
    padding: 24px 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
    position: sticky;
    top: calc(var(--nav-height) + 20px);
}

.filter-sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 16px;
    margin-bottom: 20px;
    border-bottom: 1px solid var(--clr-beige);
}

.filter-sidebar-title {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--clr-black);
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-sidebar-title svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
}

.filter-reset-link {
    font-size: 11px;
    color: var(--clr-warm-gray);
    text-decoration: underline;
    transition: color 0.2s ease;
}

.filter-reset-link:hover {
    color: var(--clr-black);
}

/* Filter Group Box */
.filter-group {
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--clr-beige);
}

.filter-group:last-of-type {
    border-bottom: none;
    margin-bottom: 16px;
    padding-bottom: 0;
}

.filter-group-title {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--clr-black);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* 1. LOẠI SẢN PHẨM (Ảnh 1) */
.category-search-box {
    position: relative;
    margin-bottom: 12px;
}

.category-search-box input {
    width: 100%;
    height: 38px;
    padding: 0 12px 0 32px;
    font-size: 12px;
    border: 1px solid var(--clr-beige);
    border-radius: 8px;
    background: var(--clr-offwhite);
    outline: none;
    transition: all 0.2s ease;
}

.category-search-box input:focus {
    border-color: var(--clr-black);
    background: var(--clr-white);
}

.category-search-box svg {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 14px;
    height: 14px;
    stroke: var(--clr-warm-gray);
    fill: none;
    stroke-width: 1.6;
}

.category-checkbox-list {
    max-height: 200px;
    overflow-y: auto;
    padding-right: 4px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* Custom scrollbar cho filter list */
.category-checkbox-list::-webkit-scrollbar {
    width: 4px;
}
.category-checkbox-list::-webkit-scrollbar-thumb {
    background: var(--clr-beige);
    border-radius: 4px;
}

.category-check-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    color: var(--clr-mid-gray);
    cursor: pointer;
    padding: 3px 0;
    transition: color 0.2s ease;
}

.category-check-item:hover {
    color: var(--clr-black);
}

.category-check-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.category-check-left input[type="radio"],
.category-check-left input[type="checkbox"] {
    accent-color: var(--clr-black);
    cursor: pointer;
    width: 15px;
    height: 15px;
}

.category-count {
    font-size: 11px;
    color: var(--clr-warm-gray);
}

/* 2. KÍCH CỠ (Ảnh 1) */
.size-button-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.size-btn-item {
    min-width: 42px;
    height: 38px;
    padding: 0 10px;
    border: 1px solid var(--clr-beige);
    border-radius: 6px;
    background: var(--clr-white);
    color: var(--clr-black);
    font-size: 12px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
}

.size-btn-item:hover {
    border-color: var(--clr-black);
}

.size-btn-item.active {
    background: var(--clr-black);
    color: var(--clr-white);
    border-color: var(--clr-black);
}

/* 3. KHOẢNG GIÁ (Ảnh 2) */
.price-range-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.price-inputs-row {
    display: flex;
    align-items: center;
    gap: 8px;
}

.price-input-box {
    flex: 1;
    position: relative;
}

.price-input-box input {
    width: 100%;
    height: 36px;
    padding: 0 20px 0 8px;
    font-size: 12px;
    border: 1px solid var(--clr-beige);
    border-radius: 6px;
    background: var(--clr-offwhite);
    outline: none;
    transition: border-color 0.2s;
}

.price-input-box input:focus {
    border-color: var(--clr-black);
    background: var(--clr-white);
}

.price-input-box .unit {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 11px;
    color: var(--clr-warm-gray);
    pointer-events: none;
}

.price-quick-options {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 4px;
}

.price-quick-btn {
    text-align: left;
    font-size: 12px;
    color: var(--clr-mid-gray);
    background: transparent;
    border: none;
    padding: 4px 0;
    cursor: pointer;
    transition: color 0.2s;
}

.price-quick-btn:hover {
    color: var(--clr-black);
}

.price-quick-btn.active {
    color: var(--clr-black);
    font-weight: 600;
}

/* NÚT SUBMIT FILTER */
.filter-action-box {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 24px;
}

.btn-filter-apply {
    width: 100%;
    height: 44px;
    background: var(--clr-black);
    color: var(--clr-white);
    border: none;
    border-radius: 10px;
    font-size: 11px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(10, 10, 10, 0.15);
}

.btn-filter-apply:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(10, 10, 10, 0.25);
}

.btn-filter-clear {
    width: 100%;
    height: 40px;
    background: transparent;
    color: var(--clr-mid-gray);
    border: 1px solid var(--clr-beige);
    border-radius: 10px;
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-filter-clear:hover {
    border-color: var(--clr-black);
    color: var(--clr-black);
}

/* -------------------- CỘT PHẢI (GRID & TOOLBAR) -------------------- */
.listing-content-col {
    display: flex;
    flex-direction: column;
}

.listing-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 20px;
    margin-bottom: 28px;
    border-bottom: 1px solid var(--clr-beige);
    flex-wrap: wrap;
    gap: 16px;
}

.listing-toolbar-left {
    display: flex;
    flex-direction: column;
}

.listing-title {
    font-family: var(--font-display);
    font-size: clamp(24px, 3vw, 32px);
    font-weight: 400;
    color: var(--clr-black);
    margin-bottom: 4px;
}

.listing-count-text {
    font-size: 12px;
    color: var(--clr-warm-gray);
    letter-spacing: 0.04em;
}

.listing-toolbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Nút toggle filter trên mobile */
.btn-mobile-filter-toggle {
    display: none;
    align-items: center;
    gap: 8px;
    height: 40px;
    padding: 0 16px;
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 8px;
    font-size: 12px;
    color: var(--clr-black);
    cursor: pointer;
}

.sort-select-wrap {
    position: relative;
}

.sort-select-input {
    height: 42px;
    padding: 0 36px 0 14px;
    font-family: var(--font-body);
    font-size: 12px;
    color: var(--clr-black);
    background: var(--clr-white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%232e2b28' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") right 14px center no-repeat;
    border: 1px solid var(--clr-beige);
    border-radius: 8px;
    outline: none;
    cursor: pointer;
    min-width: 180px;
    -webkit-appearance: none;
    appearance: none;
    transition: border-color 0.2s ease;
}

.sort-select-input:focus {
    border-color: var(--clr-black);
}

.listing-products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px 20px;
    margin-bottom: 48px;
}

/* -------------------- PAGINATION -------------------- */
.listing-pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

/* -------------------- LIGHTBOX QUICK VIEW MODAL -------------------- */
.lightbox-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 10, 10, 0.72);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.28s ease, visibility 0.28s ease;
}

.lightbox-overlay.active {
    opacity: 1;
    visibility: visible;
}

.lightbox-modal {
    background: var(--clr-ivory);
    border-radius: 18px;
    overflow: hidden;
    max-width: 760px;
    width: 100%;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
    display: grid;
    grid-template-columns: 1fr 1fr;
    position: relative;
    transform: scale(0.92);
    transition: transform 0.28s cubic-bezier(0.25, 1, 0.5, 1);
}

.lightbox-overlay.active .lightbox-modal {
    transform: scale(1);
}

.lightbox-img-wrap {
    aspect-ratio: 3 / 4;
    background: var(--clr-offwhite);
    overflow: hidden;
}

.lightbox-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.lightbox-content {
    padding: 36px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.lightbox-close-btn {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid var(--clr-beige);
    color: var(--clr-black);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 2;
}

.lightbox-close-btn:hover {
    background: var(--clr-black);
    color: var(--clr-white);
    transform: rotate(90deg);
}

.lightbox-close-btn svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    stroke-width: 2;
}

.lightbox-cat {
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    margin-bottom: 8px;
}

.lightbox-title {
    font-family: var(--font-display);
    font-size: 26px;
    font-weight: 300;
    color: var(--clr-black);
    line-height: 1.25;
    margin-bottom: 16px;
}

.lightbox-price {
    font-family: var(--font-display);
    font-size: 22px;
    color: var(--clr-black);
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--clr-beige);
}

.lightbox-btn-detail {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 44px;
    padding: 0 24px;
    background: var(--clr-black);
    color: var(--clr-white);
    font-size: 11px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    border-radius: 10px;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(10, 10, 10, 0.12);
    transition: all 0.25s ease;
    align-self: flex-start;
}

.lightbox-btn-detail:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(10, 10, 10, 0.3);
}

/* -------------------- RESPONSIVE DESIGN -------------------- */
@media (max-width: 1200px) {
    .homepage-carousel-wrapper { width: 85%; }
    .listing-layout { grid-template-columns: 260px 1fr; gap: 24px; }
    .listing-products-grid { grid-template-columns: repeat(3, 1fr); gap: 20px 16px; }
}

@media (max-width: 992px) {
    .homepage-carousel-wrapper { width: 92%; }
    .service-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .products-grid-4 { grid-template-columns: repeat(3, 1fr); }
    
    /* Listing Sidebar sang Mobile Drawer */
    .listing-layout { grid-template-columns: 1fr; }
    .btn-mobile-filter-toggle { display: inline-flex; }
    .filter-sidebar {
        display: none;
        margin-bottom: 24px;
        position: static;
    }
    .filter-sidebar.open {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    .listing-products-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 768px) {
    .homepage-carousel-wrapper { width: 95%; margin: 16px auto 32px; padding: 0 8px; }
    .auren-carousel { aspect-ratio: 16 / 10; border-radius: 12px; }
    .carousel-overlay { padding: 20px; }
    .carousel-nav-btn { width: 34px; height: 34px; }
    .carousel-nav-btn.prev { left: 8px; }
    .carousel-nav-btn.next { right: 8px; }
    
    .service-grid { grid-template-columns: 1fr; padding: 18px 20px; }
    .products-grid-4 { grid-template-columns: repeat(2, 1fr); gap: 16px 12px; }
    .listing-products-grid { grid-template-columns: repeat(2, 1fr); gap: 16px 12px; }
    
    .product-card-auren { padding: 8px; border-radius: 12px; }
    .product-img-wrap { border-radius: 8px; }
    .product-name-auren { font-size: 14px; min-height: 38px; }
    
    .lightbox-modal { grid-template-columns: 1fr; max-height: 90vh; overflow-y: auto; }
    .lightbox-img-wrap { aspect-ratio: 1 / 1; }
    .lightbox-content { padding: 24px 20px; }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

@section('content')

@if(!$isListing)
    {{-- =========================================================================
         PHẦN 1: GIAO DIỆN TRANG CHỦ (HOMEPAGE)
         - CAROUSEL THỜI TRANG 70% CĂN GIỮA, BO GÓC MỀM
         - CAM KẾT DỊCH VỤ TORANO-STYLE
         - GIỚI THIỆU THƯƠNG HIỆU AUREN
         - SECTION THEO TỪNG LOẠI SẢN PHẨM (Áo thun, Áo sơ mi, Áo polo... ~4 SP/loại)
         - NÚT "XEM TẤT CẢ [LOẠI]" ĐIỀU HƯỚNG SANG TRANG LISTING
         ========================================================================= --}}

    {{-- CAROUSEL AUREN (4 ẢNH CLOUDINARY CHUẨN) --}}
    <div class="homepage-carousel-wrapper">
        <div class="auren-carousel" id="aurenCarousel" aria-label="AUREN Carousel Banner">
            <div class="carousel-track" id="carouselTrack">
                {{-- Slide 1 --}}
                <div class="carousel-slide">
                    <img
                        src="https://res.cloudinary.com/kagefnsr/image/upload/v1791029331/carousel1.jpg"
                        alt="AUREN Fashion Collection 1"
                        loading="eager"
                    >
                    <div class="carousel-overlay">
                        <span class="carousel-tagline">AUREN · Autumn / Winter 2026</span>
                        <h2 class="carousel-title">Thời trang cho phiên bản tốt hơn của bạn</h2>
                    </div>
                </div>

                {{-- Slide 2 --}}
                <div class="carousel-slide">
                    <img
                        src="https://res.cloudinary.com/kagefnsr/image/upload/v1791029366/carousel2.jpg"
                        alt="AUREN Fashion Collection 2"
                        loading="lazy"
                    >
                    <div class="carousel-overlay">
                        <span class="carousel-tagline">New Collection · 2026</span>
                        <h2 class="carousel-title">Chất liệu cao cấp &amp; Form dáng chuẩn mực</h2>
                    </div>
                </div>

                {{-- Slide 3 --}}
                <div class="carousel-slide">
                    <img
                        src="https://res.cloudinary.com/kagefnsr/image/upload/v1791029377/carousel3.jpg"
                        alt="AUREN Fashion Collection 3"
                        loading="lazy"
                    >
                    <div class="carousel-overlay">
                        <span class="carousel-tagline">Minimal Elegance</span>
                        <h2 class="carousel-title">Tối giản trong thiết kế, tinh tế trong từng đường may</h2>
                    </div>
                </div>

                {{-- Slide 4 --}}
                <div class="carousel-slide">
                    <img
                        src="https://res.cloudinary.com/kagefnsr/image/upload/v1791029383/carousel4.jpg"
                        alt="AUREN Fashion Collection 4"
                        loading="lazy"
                    >
                    <div class="carousel-overlay">
                        <span class="carousel-tagline">Discover Your Style</span>
                        <h2 class="carousel-title">Khám phá phong cách sang trọng vượt thời gian</h2>
                    </div>
                </div>
            </div>

            {{-- Controls --}}
            <button class="carousel-nav-btn prev" id="carouselPrevBtn" aria-label="Slide trước">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="carousel-nav-btn next" id="carouselNextBtn" aria-label="Slide tiếp theo">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            {{-- Dots --}}
            <div class="carousel-dots" id="carouselDots">
                <button class="carousel-dot active" data-index="0" aria-label="Chuyển đến Slide 1"></button>
                <button class="carousel-dot" data-index="1" aria-label="Chuyển đến Slide 2"></button>
                <button class="carousel-dot" data-index="2" aria-label="Chuyển đến Slide 3"></button>
                <button class="carousel-dot" data-index="3" aria-label="Chuyển đến Slide 4"></button>
            </div>
        </div>
    </div>

    {{-- CAM KẾT DỊCH VỤ TORANO-STYLE --}}
    <section class="service-commitments">
        <div class="service-grid">
            <div class="service-item">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <div class="service-text">
                    <h4>Vận chuyển siêu tốc</h4>
                    <p>Miễn phí đơn từ 500.000đ</p>
                </div>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                </div>
                <div class="service-text">
                    <h4>Đổi trả trong 7 ngày</h4>
                    <p>Hỗ trợ đổi size/mẫu linh hoạt</p>
                </div>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div class="service-text">
                    <h4>Chất lượng chuẩn mực</h4>
                    <p>Chất liệu cao cấp chọn lọc</p>
                </div>
            </div>
            <div class="service-item">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div class="service-text">
                    <h4>Hỗ trợ tư vấn 24/7</h4>
                    <p>Tư vấn phong cách chu đáo</p>
                </div>
            </div>
        </div>
    </section>

    {{-- GIỚI THIỆU THƯƠNG HIỆU AUREN --}}
    <section class="home-intro-banner">
        <div class="intro-content-box">
            <span class="intro-brand-tag">♤ AUREN EDITORIAL</span>
            <h2 class="intro-heading">Phong cách tinh tế · May đo chuẩn mực</h2>
            <p class="intro-desc">
                AUREN hướng tới sự cân bằng hoàn hảo giữa tính thẩm mỹ tối giản và công năng sử dụng hàng ngày.
                Từng sản phẩm áo sơ mi, polo, thun và áo khoác đều được hoàn thiện tỉ mỉ để tôn vinh sự tự tin của bạn.
            </p>
            <a href="{{ route('products.index', ['view' => 'all']) }}" class="btn-explore-collection">
                Xem toàn bộ bộ sưu tập
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </section>

    {{-- CÁC SECTION THEO TỪNG LOẠI SẢN PHẨM (MỖI LOẠI HIỂN THỊ ~4 SẢN PHẨM TIÊU BIỂU) --}}
    @foreach ($categories as $cat)
        @php
            $catProducts = $cat->products->take(4);
        @endphp

        @if($catProducts->count() > 0)
            <section class="home-category-section">
                {{-- Tiêu đề Section --}}
                <div class="section-head-bar">
                    <div class="section-title-wrap">
                        <h3>{{ $cat->name }}</h3>
                        <p>Các thiết kế {{ mb_strtolower($cat->name) }} tiêu biểu được yêu thích nhất</p>
                    </div>
                    <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="section-view-all-link">
                        Xem tất cả {{ mb_strtolower($cat->name) }}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Grid 4 sản phẩm --}}
                <div class="products-grid-4">
                    @foreach ($catProducts as $product)
                        <div class="product-card-auren">
                            <div class="product-img-wrap">
                                <a href="{{ route('products.show', $product) }}" tabindex="-1" aria-hidden="true">
                                    <img
                                        src="{{ $product->image_url }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                    >
                                </a>

                                <span class="product-cat-badge">{{ $cat->name }}</span>

                                {{-- Nút con mắt Quick View --}}
                                <button
                                    type="button"
                                    class="btn-eye-quickview"
                                    aria-label="Xem nhanh sản phẩm {{ $product->name }}"
                                    title="Xem nhanh"
                                    data-name="{{ $product->name }}"
                                    data-img="{{ $product->image_url }}"
                                    data-cat="{{ $cat->name }}"
                                    data-price="{{ number_format($product->price, 0, ',', '.') }} ₫"
                                    data-url="{{ route('products.show', $product) }}"
                                >
                                    <svg viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>

                                @if($product->stock <= 0)
                                    <div class="product-sold-out-badge">
                                        <span class="product-sold-out-text">Hết hàng</span>
                                    </div>
                                @endif
                            </div>

                            <div class="product-info-auren">
                                <a href="{{ route('products.show', $product) }}" class="product-name-auren" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </a>

                                <p class="product-sub-auren">
                                    @if($product->color) {{ $product->color }} @endif
                                    @if($product->size) · Size {{ $product->size }} @endif
                                </p>

                                <div class="product-price-row-auren">
                                    <span class="product-price-auren">
                                        {{ number_format($product->price, 0, ',', '.') }} ₫
                                    </span>
                                    @if($product->stock > 0)
                                        <span class="product-stock-auren">Còn {{ $product->stock }}</span>
                                    @endif
                                </div>

                                {{-- NÚT MUA NGAY --}}
                                @if($product->stock > 0)
                                    <a href="{{ route('products.show', $product) }}" class="btn-card-buy-now">
                                        <svg viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                        Mua ngay
                                    </a>
                                @else
                                    <span class="btn-card-buy-now sold-out">Hết hàng</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Nút xem tất cả loại cuối section --}}
                <div class="section-bottom-action">
                    <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="btn-see-more-category">
                        Xem tất cả {{ mb_strtolower($cat->name) }} ({{ $cat->products()->count() }})
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </section>
        @endif
    @endforeach

@else
    {{-- =========================================================================
         PHẦN 2: GIAO DIỆN TRANG XEM TẤT CẢ SẢN PHẨM (LISTING / SHOP)
         - KHÔNG CÓ CAROUSEL
         - BỐ CỤC 2 CỘT CHUẨN TORANO
           + CỘT TRÁI: SIDEBAR BỘ LỌC (LOẠI SẢN PHẨM + SEARCH LOẠI, KÍCH CỠ, KHOẢNG GIÁ)
           + CỘT PHẢI: TOOLBAR SORT, LƯỚI SẢN PHẨM, NÚT QUICK VIEW + MUA NGAY, PHÂN TRANG
         ========================================================================= --}}

    <div class="listing-page-wrapper">
        {{-- Breadcrumb --}}
        <nav class="listing-breadcrumb" aria-label="Đường dẫn trang">
            <a href="{{ route('products.index') }}">Trang chủ</a>
            <span class="sep">/</span>
            @if($selectedCategory)
                <a href="{{ route('products.index', ['view' => 'all']) }}">Tất cả sản phẩm</a>
                <span class="sep">/</span>
                <span class="current">{{ $selectedCategory->name }}</span>
            @else
                <span class="current">Tất cả sản phẩm</span>
            @endif
        </nav>

        <div class="listing-layout">
            {{-- ------------------ CỘT TRÁI: SIDEBAR BỘ LỌC (THEO 2 ẢNH) ------------------ --}}
            <aside class="filter-sidebar" id="filterSidebar">
                <div class="filter-sidebar-header">
                    <span class="filter-sidebar-title">
                        <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        Bộ lọc tìm kiếm
                    </span>
                    @if(request('category') || request('search') || request('sort') || request('size') || request('min_price') || request('max_price'))
                        <a href="{{ route('products.index', ['view' => 'all']) }}" class="filter-reset-link">Xóa tất cả</a>
                    @endif
                </div>

                <form method="GET" action="{{ route('products.index') }}" id="sidebarFilterForm">
                    <input type="hidden" name="view" value="all">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- 1. LOẠI SẢN PHẨM (THEO ẢNH 1: media_1791395622857.png) --}}
                    <div class="filter-group">
                        <div class="filter-group-title">
                            <span>Loại sản phẩm</span>
                        </div>

                        {{-- Ô tìm kiếm loại sản phẩm --}}
                        <div class="category-search-box">
                            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                            <input
                                type="text"
                                id="categoryFilterSearch"
                                placeholder="Tìm loại sản phẩm..."
                                autocomplete="off"
                            >
                        </div>

                        {{-- Danh sách checkbox loại sản phẩm có scrollbar --}}
                        <div class="category-checkbox-list" id="categoryCheckList">
                            <label class="category-check-item">
                                <div class="category-check-left">
                                    <input
                                        type="radio"
                                        name="category"
                                        value=""
                                        {{ !request('category') ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                    >
                                    <span>Tất cả sản phẩm</span>
                                </div>
                            </label>

                            @foreach ($categories as $category)
                                <label class="category-check-item" data-cat-name="{{ mb_strtolower($category->name) }}">
                                    <div class="category-check-left">
                                        <input
                                            type="radio"
                                            name="category"
                                            value="{{ $category->id }}"
                                            @checked(request('category') == $category->id)
                                            onchange="this.form.submit()"
                                        >
                                        <span>{{ $category->name }}</span>
                                    </div>
                                    <span class="category-count">({{ $category->products()->count() }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- 2. KÍCH CỠ (THEO ẢNH 1: media_1791395622857.png) --}}
                    <div class="filter-group">
                        <div class="filter-group-title">
                            <span>Kích cỡ</span>
                        </div>
                        <input type="hidden" name="size" id="sizeInput" value="{{ request('size') }}">
                        <div class="size-button-group">
                            @foreach (['S', 'M', 'L', 'XL', 'XXL'] as $sizeOption)
                                <button
                                    type="button"
                                    class="size-btn-item {{ request('size') === $sizeOption ? 'active' : '' }}"
                                    data-size="{{ $sizeOption }}"
                                >
                                    {{ $sizeOption }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- 3. KHOẢNG GIÁ (THEO ẢNH 2: media_1791395653272.png) --}}
                    <div class="filter-group">
                        <div class="filter-group-title">
                            <span>Khoảng giá</span>
                        </div>
                        <div class="price-range-container">
                            <div class="price-inputs-row">
                                <div class="price-input-box">
                                    <input
                                        type="number"
                                        name="min_price"
                                        id="minPriceInput"
                                        placeholder="Từ 0"
                                        value="{{ request('min_price') }}"
                                        min="0"
                                        step="50000"
                                    >
                                    <span class="unit">₫</span>
                                </div>
                                <span style="color: var(--clr-warm-gray);">—</span>
                                <div class="price-input-box">
                                    <input
                                        type="number"
                                        name="max_price"
                                        id="maxPriceInput"
                                        placeholder="3.000.000"
                                        value="{{ request('max_price') }}"
                                        min="0"
                                        step="50000"
                                    >
                                    <span class="unit">₫</span>
                                </div>
                            </div>

                            {{-- Mức giá chọn nhanh Torano --}}
                            <div class="price-quick-options">
                                <button type="button" class="price-quick-btn" data-min="0" data-max="300000">· Dưới 300.000 ₫</button>
                                <button type="button" class="price-quick-btn" data-min="300000" data-max="500000">· 300.000 ₫ - 500.000 ₫</button>
                                <button type="button" class="price-quick-btn" data-min="500000" data-max="1000000">· 500.000 ₫ - 1.000.000 ₫</button>
                                <button type="button" class="price-quick-btn" data-min="1000000" data-max="3000000">· Trên 1.000.000 ₫</button>
                            </div>
                        </div>
                    </div>

                    {{-- Hành động áp dụng --}}
                    <div class="filter-action-box">
                        <button type="submit" class="btn-filter-apply">Áp dụng bộ lọc</button>
                        <a href="{{ route('products.index', ['view' => 'all']) }}" class="btn-filter-clear">Xóa bộ lọc</a>
                    </div>
                </form>
            </aside>

            {{-- ------------------ CỘT PHẢI: PRODUCT LIST & TOOLBAR ------------------ --}}
            <main class="listing-content-col">
                {{-- Toolbar --}}
                <div class="listing-toolbar">
                    <div class="listing-toolbar-left">
                        <h1 class="listing-title">
                            @if($selectedCategory)
                                {{ $selectedCategory->name }}
                            @elseif(request('search'))
                                Kết quả: "{{ request('search') }}"
                            @else
                                Tất cả sản phẩm
                            @endif
                        </h1>
                        <span class="listing-count-text">
                            Hiển thị {{ $products->count() }} trên tổng số {{ $products->total() }} sản phẩm
                        </span>
                    </div>

                    <div class="listing-toolbar-right">
                        {{-- Nút bật filter trên mobile --}}
                        <button type="button" class="btn-mobile-filter-toggle" id="mobileFilterToggleBtn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                            Bộ lọc
                        </button>

                        {{-- Dropdown sắp xếp --}}
                        <div class="sort-select-wrap">
                            <select
                                name="sort"
                                class="sort-select-input"
                                id="listingSortSelect"
                                onchange="handleSortChange(this.value)"
                            >
                                <option value="" @selected(!request('sort'))>Sắp xếp mặc định</option>
                                <option value="price_asc"  @selected(request('sort') == 'price_asc')>Giá: Thấp → Cao</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Giá: Cao → Thấp</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Grid sản phẩm Listing --}}
                <div class="listing-products-grid" id="listingProductsGrid">
                    @forelse ($products as $product)
                        <div
                            class="product-card-auren"
                            data-price="{{ (int)$product->price }}"
                            data-size="{{ strtoupper($product->size ?? '') }}"
                        >
                            {{-- Image Wrap --}}
                            <div class="product-img-wrap">
                                <a href="{{ route('products.show', $product) }}" tabindex="-1" aria-hidden="true">
                                    <img
                                        src="{{ $product->image_url }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                    >
                                </a>

                                @if($product->category)
                                    <span class="product-cat-badge">{{ $product->category->name }}</span>
                                @endif

                                {{-- Nút con mắt Quick View --}}
                                <button
                                    type="button"
                                    class="btn-eye-quickview"
                                    aria-label="Xem ảnh lớn {{ $product->name }}"
                                    title="Xem ảnh lớn"
                                    data-name="{{ $product->name }}"
                                    data-img="{{ $product->image_url }}"
                                    data-cat="{{ $product->category?->name ?? 'AUREN' }}"
                                    data-price="{{ number_format($product->price, 0, ',', '.') }} ₫"
                                    data-url="{{ route('products.show', $product) }}"
                                >
                                    <svg viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>

                                @if($product->stock <= 0)
                                    <div class="product-sold-out-badge">
                                        <span class="product-sold-out-text">Hết hàng</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="product-info-auren">
                                <a href="{{ route('products.show', $product) }}" class="product-name-auren" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </a>

                                <p class="product-sub-auren">
                                    @if($product->color) {{ $product->color }} @endif
                                    @if($product->size) · Size {{ $product->size }} @endif
                                </p>

                                <div class="product-price-row-auren">
                                    <span class="product-price-auren">
                                        {{ number_format($product->price, 0, ',', '.') }} ₫
                                    </span>
                                    @if($product->stock > 0)
                                        <span class="product-stock-auren">Còn {{ $product->stock }}</span>
                                    @endif
                                </div>

                                {{-- NÚT MUA NGAY --}}
                                @if($product->stock > 0)
                                    <a href="{{ route('products.show', $product) }}" class="btn-card-buy-now">
                                        <svg viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                        Mua ngay
                                    </a>
                                @else
                                    <span class="btn-card-buy-now sold-out">Hết hàng</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; background: var(--clr-white); border: 1px solid var(--clr-beige); border-radius: 16px;">
                            <h3 style="font-family: var(--font-display); font-size: 24px; margin-bottom: 10px; color: var(--clr-black);">Không tìm thấy sản phẩm phù hợp</h3>
                            <p style="font-size: 13px; color: var(--clr-warm-gray); margin-bottom: 20px;">Hãy thử tìm kiếm với từ khóa khác hoặc điều chỉnh lại bộ lọc.</p>
                            <a href="{{ route('products.index', ['view' => 'all']) }}" class="btn-filter-apply" style="display: inline-block; width: auto; padding: 10px 28px; text-decoration: none;">
                                Xem tất cả sản phẩm
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="listing-pagination">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>
@endif

{{-- ======================== LIGHTBOX MODAL (QUICK VIEW) ======================== --}}
<div class="lightbox-overlay" id="imageLightbox" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="lightbox-modal">
        <button class="lightbox-close-btn" id="lightboxCloseBtn" aria-label="Đóng cửa sổ">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="lightbox-img-wrap">
            <img id="lightboxImg" src="" alt="Ảnh sản phẩm">
        </div>
        <div class="lightbox-content">
            <span class="lightbox-cat" id="lightboxCat">AUREN</span>
            <h3 class="lightbox-title" id="lightboxTitle">Tên sản phẩm</h3>
            <div class="lightbox-price" id="lightboxPrice">0 ₫</div>
            <a href="#" class="lightbox-btn-detail" id="lightboxLink">
                Xem chi tiết
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    // -------------------- 1. CAROUSEL TRANG CHỦ --------------------
    const carousel = document.getElementById('aurenCarousel');
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('carouselPrevBtn');
    const nextBtn = document.getElementById('carouselNextBtn');
    const dots = document.querySelectorAll('.carousel-dot');

    if (carousel && track) {
        let currentIndex = 0;
        const totalSlides = 4;
        const autoplayInterval = 4000;
        let timer = null;

        function updateCarousel(index) {
            currentIndex = (index + totalSlides) % totalSlides;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === currentIndex);
            });
        }

        function startAutoplay() {
            stopAutoplay();
            timer = setInterval(() => {
                updateCarousel(currentIndex + 1);
            }, autoplayInterval);
        }

        function stopAutoplay() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                updateCarousel(currentIndex - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                updateCarousel(currentIndex + 1);
            });
        }

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                e.stopPropagation();
                const targetIndex = parseInt(dot.getAttribute('data-index'), 10);
                updateCarousel(targetIndex);
            });
        });

        carousel.addEventListener('mouseenter', stopAutoplay);
        carousel.addEventListener('mouseleave', startAutoplay);

        startAutoplay();
    }

    // -------------------- 2. LIGHTBOX QUICK VIEW --------------------
    const lightbox = document.getElementById('imageLightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxTitle = document.getElementById('lightboxTitle');
    const lightboxCat = document.getElementById('lightboxCat');
    const lightboxPrice = document.getElementById('lightboxPrice');
    const lightboxLink = document.getElementById('lightboxLink');
    const closeBtn = document.getElementById('lightboxCloseBtn');

    function openLightbox(data) {
        if (!lightbox) return;
        lightboxImg.src = data.img;
        lightboxImg.alt = data.name;
        lightboxTitle.textContent = data.name;
        lightboxCat.textContent = data.cat;
        lightboxPrice.textContent = data.price;
        lightboxLink.href = data.url;

        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        if (!lightbox) return;
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.btn-eye-quickview').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            openLightbox({
                name: btn.getAttribute('data-name'),
                img: btn.getAttribute('data-img'),
                cat: btn.getAttribute('data-cat'),
                price: btn.getAttribute('data-price'),
                url: btn.getAttribute('data-url')
            });
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
    if (lightbox) {
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox && lightbox.classList.contains('active')) {
            closeLightbox();
        }
    });

    // -------------------- 3. SIDEBAR FILTER INTERACTIONS --------------------
    // Tìm kiếm nhanh loại sản phẩm (Ảnh 1)
    const catSearchInput = document.getElementById('categoryFilterSearch');
    if (catSearchInput) {
        catSearchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            const items = document.querySelectorAll('#categoryCheckList .category-check-item[data-cat-name]');
            items.forEach(item => {
                const name = item.getAttribute('data-cat-name') || '';
                if (name.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Chọn size (Ảnh 1)
    const sizeButtons = document.querySelectorAll('.size-btn-item');
    const sizeInput = document.getElementById('sizeInput');
    sizeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const sizeVal = this.getAttribute('data-size');
            if (this.classList.contains('active')) {
                this.classList.remove('active');
                if (sizeInput) sizeInput.value = '';
            } else {
                sizeButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                if (sizeInput) sizeInput.value = sizeVal;
            }
            filterCardsClientside();
        });
    });

    // Chọn nhanh khoảng giá (Ảnh 2)
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');
    const quickPriceBtns = document.querySelectorAll('.price-quick-btn');

    quickPriceBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            quickPriceBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const min = this.getAttribute('data-min');
            const max = this.getAttribute('data-max');
            if (minPriceInput) minPriceInput.value = min;
            if (maxPriceInput) maxPriceInput.value = max;
            filterCardsClientside();
        });
    });

    if (minPriceInput) minPriceInput.addEventListener('input', filterCardsClientside);
    if (maxPriceInput) maxPriceInput.addEventListener('input', filterCardsClientside);

    // Lọc tức thì trên trang hiện tại theo Size & Khoảng giá
    function filterCardsClientside() {
        const activeSizeBtn = document.querySelector('.size-btn-item.active');
        const selectedSize = activeSizeBtn ? activeSizeBtn.getAttribute('data-size') : '';
        const minP = minPriceInput && minPriceInput.value ? parseInt(minPriceInput.value, 10) : 0;
        const maxP = maxPriceInput && maxPriceInput.value ? parseInt(maxPriceInput.value, 10) : Infinity;

        const cards = document.querySelectorAll('#listingProductsGrid .product-card-auren');
        cards.forEach(card => {
            const cardPrice = parseInt(card.getAttribute('data-price') || '0', 10);
            const cardSize = (card.getAttribute('data-size') || '').toUpperCase();

            let matchPrice = cardPrice >= minP && cardPrice <= maxP;
            let matchSize = !selectedSize || cardSize.includes(selectedSize);

            if (matchPrice && matchSize) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Toggle Mobile Filter Drawer
    const mobileFilterBtn = document.getElementById('mobileFilterToggleBtn');
    const filterSidebar = document.getElementById('filterSidebar');
    if (mobileFilterBtn && filterSidebar) {
        mobileFilterBtn.addEventListener('click', function () {
            filterSidebar.classList.toggle('open');
        });
    }

})();

// Hàm xử lý đổi Sort nhanh chóng
function handleSortChange(sortVal) {
    const url = new URL(window.location.href);
    if (sortVal) {
        url.searchParams.set('sort', sortVal);
    } else {
        url.searchParams.delete('sort');
    }
    url.searchParams.set('view', 'all');
    window.location.href = url.toString();
}
</script>
@endpush