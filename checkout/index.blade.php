@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<div class="auren-checkout-container py-5" style="background-color: #f7f5f0; min-height: 100vh; font-family: 'Playfair Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div class="container" style="max-width: 1140px;">
        
        {{-- Header trang --}}
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="h2 text-dark font-serif mb-0" style="font-weight: 400; letter-spacing: -0.5px;">Thanh toán đơn hàng</h1>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark px-4 py-2 text-uppercase" style="font-size: 11px; letter-spacing: 1.5px; border-radius: 6px; border-color: #000;">
                &lt; Quay lại giỏ hàng
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger mb-4 rounded-3 border-0 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row g-5">
                {{-- Cột trái: Form nhập thông tin người nhận --}}
                <div class="col-lg-7">
                    <div class="mb-4">
                        <h5 class="text-uppercase fw-bold mb-4" style="font-size: 11px; letter-spacing: 1.5px; color: #555;">Địa chỉ nhận hàng</h5>
                        
                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Họ và tên người nhận <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="receiver_name" 
                                   class="form-control bg-white border-0 py-3 px-3 custom-input @error('receiver_name') is-invalid @enderror" 
                                   value="{{ old('receiver_name', auth()->user()->name ?? '') }}" 
                                   placeholder="Ví dụ: Nguyễn Văn A" required>
                            @error('receiver_name')
                                <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Số điện thoại <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="phone" 
                                   class="form-control bg-white border-0 py-3 px-3 custom-input @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                   placeholder="09xx xxx xxx" required>
                            @error('phone')
                                <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Địa chỉ giao hàng cụ thể <span class="text-danger">*</span>
                            </label>
                            <textarea name="address" rows="3" 
                                      class="form-control bg-white border-0 py-3 px-3 custom-input @error('address') is-invalid @enderror" 
                                      placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." required>{{ old('address', auth()->user()->address ?? '') }}</textarea>
                            @error('address')
                                <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Ghi chú đơn hàng (tùy chọn)
                            </label>
                            <textarea name="note" rows="3" 
                                      class="form-control bg-white border-0 py-3 px-3 custom-input" 
                                      placeholder="Ghi chú thêm về thời gian giao hàng...">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Cột phải: Tóm tắt đơn hàng --}}
                <div class="col-lg-5">
                    <div class="p-4 bg-white rounded-3 shadow-sm mb-4" style="border: 1px solid #eae6df;">
                        <h5 class="text-uppercase fw-bold mb-4" style="font-size: 11px; letter-spacing: 1.5px; color: #555;">Đơn hàng của bạn</h5>

                        <div class="cart-items mb-4">
                            @if(isset($cartItems) && count($cartItems) > 0)
                                @foreach($cartItems as $item)
                                    <div class="py-3 border-bottom d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 14px;">{{ $item->product->name ?? 'Sản phẩm' }}</div>
                                            <div class="text-muted" style="font-size: 12px;">SL: {{ $item->quantity }}</div>
                                        </div>
                                        <div class="fw-medium text-dark" style="font-size: 14px;">
                                            {{ number_format(($item->price ?? $item->product->price) * $item->quantity) }} đ
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($cart) && count($cart) > 0)
                                @foreach($cart as $item)
                                    <div class="py-3 border-bottom d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 14px;">{{ $item['name'] }}</div>
                                            <div class="text-muted" style="font-size: 12px;">SL: {{ $item['quantity'] }}</div>
                                        </div>
                                        <div class="fw-medium text-dark" style="font-size: 14px;">
                                            {{ number_format($item['price'] * $item['quantity']) }} đ
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 mb-4">
                            <span class="text-uppercase fw-bold" style="font-size: 12px; letter-spacing: 1px;">Tổng thanh toán</span>
                            <span class="fs-5 fw-bold text-dark">{{ number_format($totalPrice ?? $total ?? 0) }} đ</span>
                        </div>

                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-dark w-100 py-3 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1.5px; border-radius: 6px; background-color: #000;">
                                ✓ Đặt hàng ngay
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark px-4 py-3 text-uppercase" style="font-size: 11px; letter-spacing: 1.5px; border-radius: 6px; border-color: #ccc;">
                                Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .auren-checkout-container .custom-input {
        border-radius: 8px !important;
        font-size: 13px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .auren-checkout-container .custom-input:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 2px #000 !important;
        outline: none;
    }
</style>
@endsection