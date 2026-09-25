<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Web Bán Áo</title>
</head>
<body>
    <h1>Danh sách sản phẩm</h1>

    <form method="GET" action="{{ route('products.index') }}">
        <input
            type="text"
            name="search"
            placeholder="Tìm sản phẩm..."
            value="{{ request('search') }}"
        >

        <select name="category">
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

        <button type="submit">Tìm kiếm</button>
    </form>

    <hr>

    @forelse ($products as $product)
        <div style="margin-bottom: 25px;">
            @if ($product->image)
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    width="180"
                >
            @endif

            <h2>
                <a href="{{ route('products.show', $product) }}">
                    {{ $product->name }}
                </a>
            </h2>

            <p>Danh mục: {{ $product->category?->name }}</p>
            <p>Giá: {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
            <p>Còn lại: {{ $product->stock }}</p>
        </div>
    @empty
        <p>Chưa có sản phẩm nào.</p>
    @endforelse

    {{ $products->links() }}
</body>
</html>