@extends('layouts.app')

@section('title', 'Bộ sưu tập')

@section('extra-css')
<style>

.carousel-container {
    max-width: var(--max-width);
    margin: 24px auto 40px;
    padding: 0 var(--spacing-md);
}

.auren-carousel {
    position: relative;
    width: 100%;
    aspect-ratio: 1344 / 768;
    border-radius: 0;
    overflow: hidden;
    box-shadow: none;
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
    border-radius: 0;
}

.carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center center;
    display: block;
    border-radius: 0;
    user-select: none;
    -webkit-user-drag: none;
}

.carousel-overlay {
    position: absolute;
    inset: 0;
    background: transparent;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 28px 36px;
    color: var(--clr-white);
    pointer-events: none;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
}

.carousel-tagline {
    font-size: 11px;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 4px;
}

.carousel-title {
    font-family: var(--font-display);
    font-size: clamp(22px, 3.5vw, 38px);
    font-weight: 300;
    letter-spacing: 0.04em;
    color: var(--clr-white);
    line-height: 1.2;
}

.carousel-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.5);
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
    transform: translateY(-50%) scale(1.05);
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
    width: 24px;
    height: 3px;
    border-radius: 0;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.carousel-dot.active {
    width: 44px;
    background: #ffffff;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
}

.page-hero {
    padding: 24px 0 32px;
    border-bottom: 1px solid var(--clr-beige);
    margin-bottom: 36px;
}

.page-hero-inner {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.page-hero-label {
    font-size: 11px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    margin-bottom: 8px;
}

.page-hero-title {
    font-family: var(--font-display);
    font-size: clamp(30px, 4.5vw, 48px);
    font-weight: 300;
    color: var(--clr-black);
    line-height: 1.15;
    letter-spacing: -0.01em;
}

.page-hero-count {
    font-size: 12px;
    color: var(--clr-warm-gray);
    letter-spacing: 0.08em;
    align-self: flex-end;
    padding-bottom: 4px;
}

.filter-bar {
    max-width: var(--max-width);
    margin: 0 auto 40px;
    padding: 0 var(--spacing-md);
}

.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}

.filter-search-wrap {
    flex: 1;
    min-width: 220px;
    position: relative;
}

.filter-search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--clr-warm-gray);
}

.filter-search-icon svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.5;
}

.filter-search-input {
    width: 100%;
    height: 46px;
    padding: 0 16px 0 44px;
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 300;
    color: var(--clr-black);
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 10px;
    outline: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    transition: all 0.25s ease;
    -webkit-appearance: none;
    appearance: none;
}

.filter-search-input:focus {
    border-color: var(--clr-black);
    box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.08);
}

.filter-search-input::placeholder { color: var(--clr-warm-gray); }

.filter-select {
    height: 46px;
    padding: 0 36px 0 16px;
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 300;
    color: var(--clr-black);
    background: var(--clr-white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%232e2b28' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") right 14px center no-repeat;
    border: 1px solid var(--clr-beige);
    border-radius: 10px;
    outline: none;
    cursor: pointer;
    min-width: 170px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    -webkit-appearance: none;
    appearance: none;
    transition: all 0.25s ease;
}

.filter-select:focus {
    border-color: var(--clr-black);
    box-shadow: 0 0 0 3px rgba(10, 10, 10, 0.08);
}

.filter-btn-submit {
    height: 46px;
    padding: 0 28px;
    background: var(--clr-black);
    color: var(--clr-white);
    font-family: var(--font-body);
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(10, 10, 10, 0.12);
    transition: all 0.25s ease;
    white-space: nowrap;
}

.filter-btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(10, 10, 10, 0.28);
    opacity: 0.9;
}

.filter-btn-reset {
    height: 46px;
    padding: 0 20px;
    background: transparent;
    color: var(--clr-mid-gray);
    font-family: var(--font-body);
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    border: 1px solid var(--clr-beige);
    border-radius: 10px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.filter-btn-reset:hover {
    border-color: var(--clr-black);
    color: var(--clr-black);
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.products-grid {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md);
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px 24px;
    margin-bottom: 64px;
}

.product-card-auren {
    display: flex;
    flex-direction: column;
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 16px;
    overflow: hidden;
    padding: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                box-shadow 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
}

.product-card-auren:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 26px rgba(0, 0, 0, 0.08);
}

.product-img-wrap {
    position: relative;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: var(--clr-offwhite);
    border-radius: 12px;
    margin-bottom: 14px;
}

.product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.product-card-auren:hover .product-img-wrap img {
    transform: scale(1.04);
}

.product-cat-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 9px;
    font-weight: 400;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--clr-white);
    background: rgba(10, 10, 10, 0.85);
    backdrop-filter: blur(4px);
    padding: 4px 8px;
    border-radius: 6px;
}

/* Nút con mắt Quick View */
.btn-eye-quickview {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.5);
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
    background: var(--clr-black);
    color: var(--clr-white);
    box-shadow: 0 4px 14px rgba(10, 10, 10, 0.3);
    transform: scale(1.1) !important;
}

.btn-eye-quickview svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.6;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.product-sold-out-badge {
    position: absolute;
    inset: 0;
    background: rgba(248, 245, 240, 0.75);
    backdrop-filter: blur(2px);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
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
    padding: 2px 4px 4px;
}

.product-name-auren {
    font-family: var(--font-display);
    font-size: 17px;
    font-weight: 400;
    line-height: 1.3;
    color: var(--clr-black);
    margin-bottom: 4px;
    transition: opacity 0.25s ease;
}

.product-name-auren:hover { opacity: 0.65; }

.product-sub-auren {
    font-size: 12px;
    color: var(--clr-warm-gray);
    letter-spacing: 0.05em;
    margin-bottom: 12px;
    flex-grow: 1;
}

.product-price-row-auren {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid var(--clr-beige);
    padding-top: 10px;
    margin-top: auto;
}

.product-price-auren {
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 400;
    color: var(--clr-black);
}

.product-stock-auren {
    font-size: 10px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
}

.products-empty {
    grid-column: 1 / -1;
    padding: 80px 20px;
    text-align: center;
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    border-radius: 16px;
}

.products-empty-title {
    font-family: var(--font-display);
    font-size: 28px;
    font-weight: 300;
    color: var(--clr-black);
    margin-bottom: 14px;
}

.products-empty-sub {
    font-size: 13px;
    color: var(--clr-warm-gray);
    margin-bottom: 24px;
}

.pagination-wrap {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md) 80px;
    display: flex;
    justify-content: center;
}

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
    line-height: 1.2;
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

@media (max-width: 1024px) {
    .products-grid { grid-template-columns: repeat(3, 1fr); }
    .auren-carousel { aspect-ratio: 1344 / 768; border-radius: 0; }
}

@media (max-width: 768px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); gap: 18px 14px; }
    .auren-carousel { aspect-ratio: 1344 / 768; border-radius: 0; }
    .carousel-nav-btn { width: 36px; height: 36px; }
    .carousel-nav-btn.prev { left: 10px; }
    .carousel-nav-btn.next { right: 10px; }
    .carousel-overlay { padding: 20px; }
    .page-hero-inner { flex-direction: column; align-items: flex-start; }
    .filter-form { flex-direction: column; align-items: stretch; }
    .filter-select, .filter-btn-submit, .filter-btn-reset { width: 100%; }
    .lightbox-modal { grid-template-columns: 1fr; max-height: 90vh; overflow-y: auto; }
    .lightbox-img-wrap { aspect-ratio: 1 / 1; }
    .lightbox-content { padding: 24px 20px; }
}

@media (max-width: 480px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); gap: 14px 10px; }
    .product-card-auren { padding: 8px; border-radius: 12px; }
    .product-img-wrap { border-radius: 10px; }
}
</style>
@endsection

@section('content')

{{-- ======================== CAROUSEL AUREN (4 SLIDES CLOUDINARY) ======================== --}}
<div class="carousel-container">
    <div class="auren-carousel" id="aurenCarousel" aria-label="AUREN Carousel Banner">
        <div class="carousel-track" id="carouselTrack">
            {{-- Slide 1 --}}
            <div class="carousel-slide">
                <img
                    src="https://res.cloudinary.com/kagefnsr/image/upload/v1791029331/carousel1.jpg"
                    alt="AUREN Editorial Fashion Collection 1"
                    loading="eager"
                >
                <div class="carousel-overlay">
                    <span class="carousel-tagline">AUREN · Autumn / Winter</span>
                    <h2 class="carousel-title">Thời trang cho phiên bản tốt hơn của bạn</h2>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="carousel-slide">
                <img
                    src="https://res.cloudinary.com/kagefnsr/image/upload/v1791029366/carousel2.jpg"
                    alt="AUREN Editorial Fashion Collection 2"
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
                    alt="AUREN Editorial Fashion Collection 3"
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
                    alt="AUREN Editorial Fashion Collection 4"
                    loading="lazy"
                >
                <div class="carousel-overlay">
                    <span class="carousel-tagline">Discover Your Style</span>
                    <h2 class="carousel-title">Khám phá phong cách sang trọng vượt thời gian</h2>
                </div>
            </div>
        </div>

        {{-- Nút Previous / Next --}}
        <button class="carousel-nav-btn prev" id="carouselPrevBtn" aria-label="Slide trước">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button class="carousel-nav-btn next" id="carouselNextBtn" aria-label="Slide tiếp theo">
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

        {{-- Dots Indicator --}}
        <div class="carousel-dots" id="carouselDots">
            <button class="carousel-dot active" data-index="0" aria-label="Chuyển đến Slide 1"></button>
            <button class="carousel-dot" data-index="1" aria-label="Chuyển đến Slide 2"></button>
            <button class="carousel-dot" data-index="2" aria-label="Chuyển đến Slide 3"></button>
            <button class="carousel-dot" data-index="3" aria-label="Chuyển đến Slide 4"></button>
        </div>
    </div>
</div>

{{-- ======================== PAGE HERO ======================== --}}
<div class="page-hero">
    <div class="page-hero-inner">
        <div>
            <p class="page-hero-label reveal-up">Bộ sưu tập</p>
            <h1 class="page-hero-title reveal-up reveal-delay-1">Tất cả sản phẩm</h1>
        </div>
        <span class="page-hero-count reveal-up reveal-delay-2">
            {{ $products->total() }} sản phẩm
        </span>
    </div>
</div>

{{-- ======================== FILTER BAR ======================== --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('products.index') }}" class="filter-form">

        {{-- Search input --}}
        <div class="filter-search-wrap">
            <span class="filter-search-icon">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </span>
            <input
                type="text"
                name="search"
                class="filter-search-input"
                placeholder="Tìm sản phẩm..."
                value="{{ request('search') }}"
            >
        </div>

        {{-- Category filter --}}
        <select name="category" class="filter-select">
            <option value="">Tất cả danh mục</option>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(request('category') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        {{-- Sort --}}
        <select name="sort" class="filter-select">
            <option value="">Sắp xếp mặc định</option>
            <option value="price_asc"  @selected(request('sort') == 'price_asc')>Giá: Thấp → Cao</option>
            <option value="price_desc" @selected(request('sort') == 'price_desc')>Giá: Cao → Thấp</option>
        </select>

        <button type="submit" class="filter-btn-submit">Lọc</button>

        @if(request('search') || request('category') || request('sort'))
            <a href="{{ route('products.index') }}" class="filter-btn-reset">Đặt lại</a>
        @endif

    </form>
</div>

{{-- ======================== PRODUCT GRID ======================== --}}
<div class="products-grid">
    @forelse ($products as $product)
        <div class="product-card-auren reveal-up reveal-delay-{{ ($loop->index % 4) + 1 }}">

            {{-- Image & Actions --}}
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

                {{-- Nút con mắt Quick View / Xem ảnh lớn --}}
                <button
                    type="button"
                    class="btn-eye-quickview"
                    aria-label="Xem ảnh lớn sản phẩm {{ $product->name }}"
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

            {{-- Info --}}
            <div class="product-info-auren">
                <a href="{{ route('products.show', $product) }}" class="product-name-auren">
                    {{ $product->name }}
                </a>

                <p class="product-sub-auren">
                    @if($product->color) {{ $product->color }} @endif
                    @if($product->size) · {{ $product->size }} @endif
                </p>

                <div class="product-price-row-auren">
                    <span class="product-price-auren">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                    </span>
                    @if($product->stock > 0)
                        <span class="product-stock-auren">Còn {{ $product->stock }}</span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="products-empty">
            <h2 class="products-empty-title">Không tìm thấy sản phẩm</h2>
            <p class="products-empty-sub">Thử tìm kiếm với từ khóa khác hoặc xóa bộ lọc.</p>
            <a href="{{ route('products.index') }}" class="btn-arrow">
                Xem tất cả sản phẩm
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M1 7h16M10 1l6 6-6 6"/></svg>
            </a>
        </div>
    @endforelse
</div>

{{-- ======================== PAGINATION ======================== --}}
<div class="pagination-wrap">
    {{ $products->links() }}
</div>

{{-- ======================== LIGHTBOX MODAL ======================== --}}
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

    const carousel = document.getElementById('aurenCarousel');
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('carouselPrevBtn');
    const nextBtn = document.getElementById('carouselNextBtn');
    const dots = document.querySelectorAll('.carousel-dot');

    if (carousel && track) {
        let currentIndex = 0;
        const totalSlides = 4;
        const autoplayInterval = 3000; 
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

    if (closeBtn) {
        closeBtn.addEventListener('click', closeLightbox);
    }
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

})();
</script>
@endpush