@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@section('content')
{{-- Thêm pt-5 mt-5 để đẩy nội dung xuống dưới Navbar --}}
<div class="auren-cart-container pt-5 mt-5 pb-5" style="background-color: #f7f5f0; min-height: 100vh; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div class="container" style="max-width: 1140px;">

        {{-- Header trang giỏ hàng: Thêm mt-4 để hạ tiêu đề xuống khỏi mép trên --}}
        <div class="d-flex justify-content-between align-items-center mb-5 mt-4">
            <h1 class="h2 text-dark font-serif mb-0" style="font-weight: 400; letter-spacing: -0.5px;">Giỏ hàng của bạn</h1>
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark px-4 py-2 text-uppercase" style="font-size: 11px; letter-spacing: 1.5px; border-radius: 6px; border-color: #000;">
                &lt; Tiếp tục mua sắm
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4 border-0 rounded-3 shadow-sm bg-white text-dark" style="border-left: 4px solid #000 !important;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4 border-0 rounded-3 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)
            <div class="row g-5">
                {{-- Danh sách sản phẩm trong giỏ --}}
                <div class="col-lg-8">
                    <div class="bg-white rounded-3 shadow-sm p-4 mb-4" style="border: 1px solid #eae6df;">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="border-color: #f0ede6;">
                                <thead>
                                    <tr class="text-uppercase text-muted" style="font-size: 11px; letter-spacing: 1.5px;">
                                        <th scope="col" class="pb-3 border-0">Sản phẩm</th>
                                        <th scope="col" class="pb-3 border-0 text-center">Đơn giá</th>
                                        <th scope="col" class="pb-3 border-0 text-center">Số lượng</th>
                                        <th scope="col" class="pb-3 border-0 text-end">Thành tiền</th>
                                        <th scope="col" class="pb-3 border-0 text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    @if(isset($item->product->image))
                                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" 
                                                             class="rounded-2 me-3" style="width: 60px; height: 60px; object-fit: cover; background-color: #f7f5f0;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1 fw-bold text-dark" style="font-size: 14px;">{{ $item->product->name ?? $item['name'] }}</h6>
                                                        @if(isset($item->product->size) || isset($item->size))
                                                            <span class="text-muted" style="font-size: 12px;">Size: {{ $item->product->size ?? $item['size'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 text-center text-dark fw-medium" style="font-size: 14px;">
                                                {{ number_format($item->price ?? $item['price']) }} đ
                                            </td>
                                            <td class="py-3 text-center" style="width: 140px;">
                                                <form action="{{ route('cart.update', $item->id ?? $item['id']) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity ?? $item['quantity'] }}" min="1" 
                                                           class="form-control text-center bg-white custom-cart-qty p-1" style="width: 60px; font-size: 13px; border-radius: 6px; border: 1px solid #ddd;"
                                                           onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="py-3 text-end fw-bold text-dark" style="font-size: 14px;">
                                                {{ number_format(($item->price ?? $item['price']) * ($item->quantity ?? $item['quantity'])) }} đ
                                            </td>
                                            <td class="py-3 text-end">
                                                <form action="{{ route('cart.destroy', $item->id ?? $item['id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-muted p-0 text-decoration-none" 
                                                            onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')" style="font-size: 16px;">
                                                        &times;
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Khối tóm tắt thanh toán --}}
                <div class="col-lg-4">
                    <div class="bg-white rounded-3 shadow-sm p-4" style="border: 1px solid #eae6df;">
                        <h5 class="text-uppercase fw-bold mb-4" style="font-size: 11px; letter-spacing: 1.5px; color: #555;">Tóm tắt đơn hàng</h5>

                        <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                            <span class="text-muted" style="font-size: 13px;">Tạm tính</span>
                            <span class="fw-bold text-dark" style="font-size: 14px;">{{ number_format($totalPrice ?? $total ?? 0) }} đ</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4 pb-2 border-bottom">
                            <span class="text-muted" style="font-size: 13px;">Phí vận chuyển</span>
                            <span class="text-success fw-medium" style="font-size: 13px;">Miễn phí</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-uppercase fw-bold" style="font-size: 12px; letter-spacing: 1px;">Tổng cộng</span>
                            <span class="fs-4 fw-bold text-dark">{{ number_format($totalPrice ?? $total ?? 0) }} đ</span>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-dark py-3 text-uppercase fw-bold text-center" style="font-size: 11px; letter-spacing: 1.5px; border-radius: 6px; background-color: #000;">
                                ✓ Tiến hành thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Trạng thái giỏ hàng trống --}}
            <div class="bg-white rounded-3 shadow-sm p-5 text-center my-4" style="border: 1px solid #eae6df;">
                <p class="text-muted mb-4" style="font-size: 14px;">Giỏ hàng của bạn hiện đang trống.</p>
                <a href="{{ route('products.index') }}" class="btn btn-dark px-4 py-3 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1.5px; border-radius: 6px; background-color: #000;">
                    Khám phá sản phẩm ngay
                </a>
            </div>
        @endif
    </div>
</div>
@endsection