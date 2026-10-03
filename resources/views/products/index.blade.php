@extends('layouts.app')

@section('title', 'Bộ sưu tập')

@section('extra-css')
<style>

.page-hero {
    padding: 56px 0 40px;
    border-bottom: 1px solid var(--clr-beige);
    margin-bottom: 48px;
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
    margin-bottom: 10px;
}

.page-hero-title {
    font-family: var(--font-display);
    font-size: clamp(32px, 5vw, 56px);
    font-weight: 300;
    color: var(--clr-black);
    line-height: 1.1;
    letter-spacing: -0.01em;
}

.page-hero-count {
    font-size: 12px;
    color: var(--clr-warm-gray);
    letter-spacing: 0.08em;
    align-self: flex-end;
    padding-bottom: 6px;
}

.filter-bar {
    max-width: var(--max-width);
    margin: 0 auto 48px;
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
    height: 48px;
    padding: 0 16px 0 44px;
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 300;
    color: var(--clr-black);
    background: var(--clr-white);
    border: 1px solid var(--clr-beige);
    outline: none;
    transition: border-color 0.3s ease;
    -webkit-appearance: none;
    appearance: none;
}

.filter-search-input:focus { border-color: var(--clr-black); }
.filter-search-input::placeholder { color: var(--clr-warm-gray); }

.filter-select {
    height: 48px;
    padding: 0 36px 0 16px;
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 300;
    color: var(--clr-black);
    background: var(--clr-white) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%232e2b28' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E") right 14px center no-repeat;
    border: 1px solid var(--clr-beige);
    outline: none;
    cursor: pointer;
    min-width: 160px;
    -webkit-appearance: none;
    appearance: none;
    transition: border-color 0.3s ease;
}

.filter-select:focus { border-color: var(--clr-black); }

.filter-btn-submit {
    height: 48px;
    padding: 0 28px;
    background: var(--clr-black);
    color: var(--clr-white);
    font-family: var(--font-body);
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    border: none;
    cursor: pointer;
    transition: opacity 0.3s ease;
    white-space: nowrap;
}

.filter-btn-submit:hover { opacity: 0.75; }

.filter-btn-reset {
    height: 48px;
    padding: 0 20px;
    background: transparent;
    color: var(--clr-mid-gray);
    font-family: var(--font-body);
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    border: 1px solid var(--clr-beige);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: border-color 0.3s ease, color 0.3s ease;
    white-space: nowrap;
}

.filter-btn-reset:hover {
    border-color: var(--clr-black);
    color: var(--clr-black);
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
    background: transparent;
}

.product-img-wrap {
    position: relative;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: var(--clr-offwhite);
    margin-bottom: 16px;
}

.product-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.product-card-auren:hover .product-img-wrap img {
    transform: scale(1.04);
}

.product-cat-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    font-size: 9px;
    font-weight: 400;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--clr-white);
    background: var(--clr-black);
    padding: 4px 8px;
}

.product-sold-out-badge {
    position: absolute;
    inset: 0;
    background: rgba(248,245,240,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-sold-out-text {
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--clr-mid-gray);
    background: var(--clr-ivory);
    padding: 6px 14px;
    border: 1px solid var(--clr-beige);
}

.product-info-auren {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.product-name-auren {
    font-family: var(--font-display);
    font-size: 17px;
    font-weight: 400;
    line-height: 1.3;
    color: var(--clr-black);
    margin-bottom: 6px;
    transition: opacity 0.3s ease;
}

.product-name-auren:hover { opacity: 0.6; }

.product-sub-auren {
    font-size: 12px;
    color: var(--clr-warm-gray);
    letter-spacing: 0.06em;
    margin-bottom: 12px;
    flex-grow: 1;
}

.product-price-row-auren {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid var(--clr-beige);
    padding-top: 12px;
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
}

.products-empty-title {
    font-family: var(--font-display);
    font-size: 28px;
    font-weight: 300;
    color: var(--clr-black);
    margin-bottom: 16px;
}

.products-empty-sub {
    font-size: 13px;
    color: var(--clr-warm-gray);
    margin-bottom: 28px;
}


.pagination-wrap {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 0 var(--spacing-md) 80px;
    display: flex;
    justify-content: center;
}


.pagination-wrap nav {
    display: flex;
    gap: 4px;
    align-items: center;
}


@media (max-width: 1024px) {
    .products-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 768px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); gap: 24px 16px; }
    .page-hero-inner { flex-direction: column; align-items: flex-start; }
    .filter-form { flex-direction: column; align-items: stretch; }
    .filter-select, .filter-btn-submit, .filter-btn-reset { width: 100%; }
}

@media (max-width: 480px) {
    .products-grid { grid-template-columns: repeat(2, 1fr); gap: 16px 10px; }
}
</style>
@endsection

@section('content')

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

            {{-- Image --}}
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

@endsection