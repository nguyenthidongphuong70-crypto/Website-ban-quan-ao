<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
</head>
<body>
    <a href="{{ route('products.index') }}">
        ← Quay lại sản phẩm
    </a>

    <h1>{{ $product->name }}</h1>

    @if ($product->image)
        <img
            src="{{ asset('storage/' . $product->image) }}"
            alt="{{ $product->name }}"
            width="300"
        >
    @endif

    <p>{{ $product->description }}</p>
    <p>Danh mục: {{ $product->category?->name }}</p>
    <p>Size: {{ $product->size ?: 'Chưa cập nhật' }}</p>
    <p>Màu: {{ $product->color ?: 'Chưa cập nhật' }}</p>
    <p>
        Giá:
        {{ number_format($product->price, 0, ',', '.') }} VNĐ
    </p>
    <p>Tồn kho: {{ $product->stock }}</p>

    @if ($product->stock > 0)
        <form method="POST" action="#">
            @csrf
            <button type="submit">
                Thêm vào giỏ hàng
            </button>
        </form>
    @else
        <p>Sản phẩm đã hết hàng.</p>
    @endif
</body>
</html>