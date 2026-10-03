@extends('layouts.app')

@section('title', $product->name)

@section('extra-css')
<style>
.product-back {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 32px var(--spacing-md) 0;
}

.product-back-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    transition: color 0.3s ease;
}

.product-back-link:hover { color: var(--clr-black); }

.product-back-link svg {
    width: 16px;
    height: 12px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    transition: transform 0.3s ease;
}

.product-back-link:hover svg { transform: translateX(-4px); }

.product-detail-layout {
    max-width: var(--max-width);
    margin: 0 auto;
    padding: 40px var(--spacing-md) 96px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: start;
}

.product-detail-img-wrap {
    position: relative;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: var(--clr-offwhite);
}

.product-detail-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}

.product-detail-img-wrap:hover img { transform: scale(1.03); }

.product-detail-panel {
    position: sticky;
    top: calc(var(--nav-height) + 32px);
}

.product-detail-category {
    font-size: 10px;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    margin-bottom: 16px;
    display: block;
}

.product-detail-name {
    font-family: var(--font-display);
    font-size: clamp(28px, 3.5vw, 44px);
    font-weight: 300;
    line-height: 1.15;
    color: var(--clr-black);
    margin-bottom: 24px;
    letter-spacing: 0.01em;
}

.product-detail-price {
    font-family: var(--font-display);
    font-size: 28px;
    font-weight: 400;
    color: var(--clr-black);
    margin-bottom: 32px;
    padding-bottom: 32px;
    border-bottom: 1px solid var(--clr-beige);
}

.product-specs {
    display: flex;
    flex-direction: column;
    gap: 0;
    margin-bottom: 32px;
}

.product-spec-row {
    display: flex;
    padding: 12px 0;
    border-bottom: 1px solid var(--clr-beige);
    align-items: center;
}

.product-spec-label {
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    width: 120px;
    flex-shrink: 0;
}

.product-spec-value {
    font-size: 14px;
    font-weight: 300;
    color: var(--clr-black);
}

.spec-badge-stock {
    display: inline-block;
    font-size: 10px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    padding: 3px 8px;
    border: 1px solid;
}

.spec-badge-stock.in-stock {
    color: #166534;
    border-color: #166534;
    background: #f0fdf4;
}

.spec-badge-stock.out-stock {
    color: #991b1b;
    border-color: #fecaca;
    background: #fef2f2;
}

.product-description {
    padding: 20px 0 32px;
    border-bottom: 1px solid var(--clr-beige);
    margin-bottom: 32px;
}

.product-description-label {
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    margin-bottom: 10px;
}

.product-description-text {
    font-size: 14px;
    font-weight: 300;
    line-height: 1.8;
    color: var(--clr-mid-gray);
}

.cart-action {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.qty-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 4px;
}

.qty-label {
    font-size: 10px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
    width: 80px;
}

.qty-control {
    display: flex;
    align-items: center;
    border: 1px solid var(--clr-beige);
    background: var(--clr-white);
}

.qty-btn {
    width: 40px;
    height: 44px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
    color: var(--clr-black);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s ease;
    font-weight: 300;
}

.qty-btn:hover { background: var(--clr-offwhite); }

.qty-input {
    width: 56px;
    height: 44px;
    text-align: center;
    font-family: var(--font-body);
    font-size: 14px;
    font-weight: 300;
    color: var(--clr-black);
    background: transparent;
    border: none;
    border-left: 1px solid var(--clr-beige);
    border-right: 1px solid var(--clr-beige);
    outline: none;
    -moz-appearance: textfield;
}

.qty-input::-webkit-inner-spin-button,
.qty-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.btn-add-to-cart {
    height: 56px;
    background: var(--clr-black);
    color: var(--clr-white);
    font-family: var(--font-body);
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    transition: opacity 0.3s ease;
}

.btn-add-to-cart:hover { opacity: 0.8; }

.btn-add-to-cart svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.5;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.product-out-of-stock-banner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    height: 56px;
    border: 1px solid var(--clr-beige);
    font-size: 11px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--clr-warm-gray);
}

@media (max-width: 900px) {
    .product-detail-layout {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    .product-detail-panel { position: static; }
}
</style>
@endsection

@section('content')

{{-- ======================== BACK LINK ======================== --}}
<div class="product-back">
    <a href="{{ route('products.index') }}" class="product-back-link">
        <svg viewBox="0 0 16 12"><path d="M15 6H1M6 1 1 6l5 5"/></svg>
        Quay lại bộ sưu tập
    </a>
</div>

{{-- ======================== PRODUCT DETAIL ======================== --}}
<div class="product-detail-layout">

    {{-- ---- Image side ---- --}}
    <div class="product-detail-img-wrap scale-in">
        <img
            src="{{ $product->image_url }}"
            alt="{{ $product->name }}"
        >
    </div>

    {{-- ---- Info panel (sticky) ---- --}}
    <div class="product-detail-panel reveal-up">

        {{-- Category --}}
        <span class="product-detail-category">
            {{ $product->category?->name ?? 'Sản phẩm' }}
        </span>

        {{-- Name --}}
        <h1 class="product-detail-name">{{ $product->name }}</h1>

        {{-- Price --}}
        <div class="product-detail-price">
            {{ number_format($product->price, 0, ',', '.') }} ₫
        </div>

        {{-- Specs --}}
        <div class="product-specs">
            <div class="product-spec-row">
                <span class="product-spec-label">Kích thước</span>
                <span class="product-spec-value">{{ $product->size ?: '—' }}</span>
            </div>
            <div class="product-spec-row">
                <span class="product-spec-label">Màu sắc</span>
                <span class="product-spec-value">{{ $product->color ?: '—' }}</span>
            </div>
            <div class="product-spec-row">
                <span class="product-spec-label">Tình trạng</span>
                <span class="product-spec-value">
                    @if ($product->stock > 0)
                        <span class="spec-badge-stock in-stock">Còn hàng</span>
                    @else
                        <span class="spec-badge-stock out-stock">Hết hàng</span>
                    @endif
                </span>
            </div>
        </div>

        {{-- Description — Giữ nguyên logic hiển thị --}}
        @if ($product->description)
            <div class="product-description">
                <p class="product-description-label">Mô tả sản phẩm</p>
                <p class="product-description-text">{{ $product->description }}</p>
            </div>
        @endif

        {{-- ======================== CART FORM ========================--}}
        <div class="cart-action">
            @if ($product->stock > 0)
                <form method="POST" action="{{ Route::has('cart.add') ? route('cart.add') : '#' }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="qty-row">
                        <span class="qty-label">Số lượng</span>
                        <div class="qty-control">
                            <button type="button" class="qty-btn" id="qty-minus" aria-label="Giảm số lượng">−</button>
                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="1"
                                min="1"
                                max="{{ $product->stock }}"
                                class="qty-input"
                            >
                            <button type="button" class="qty-btn" id="qty-plus" aria-label="Tăng số lượng">+</button>
                        </div>
                    </div>

                    <button type="submit" class="btn-add-to-cart">
                        <svg viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        Thêm vào giỏ hàng
                    </button>
                </form>
            @else
                <div class="product-out-of-stock-banner">
                    Sản phẩm tạm hết hàng
                </div>
            @endif
        </div>

    </div>{{-- end panel --}}
</div>{{-- end layout --}}

@push('scripts')
<script>
(function () {
    /* Quantity stepper — pure UI, không liên quan cart logic */
    const input = document.getElementById('quantity');
    const minus = document.getElementById('qty-minus');
    const plus  = document.getElementById('qty-plus');
    if (!input || !minus || !plus) return;

    const max = parseInt(input.getAttribute('max') || '99', 10);

    minus.addEventListener('click', () => {
        const v = parseInt(input.value, 10) || 1;
        if (v > 1) input.value = v - 1;
    });

    plus.addEventListener('click', () => {
        const v = parseInt(input.value, 10) || 1;
        if (v < max) input.value = v + 1;
    });

    input.addEventListener('change', () => {
        let v = parseInt(input.value, 10) || 1;
        if (v < 1) v = 1;
        if (v > max) v = max;
        input.value = v;
    });
})();
</script>
@endpush

@endsection