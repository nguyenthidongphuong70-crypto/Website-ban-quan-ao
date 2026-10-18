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

        {{-- Thêm id="checkout-form" để JavaScript quản lý action --}}
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            
            <div class="row g-5">
                {{-- Cột trái: Phương thức thanh toán & Thông tin người nhận --}}
                <div class="col-lg-7">
                    
                    {{-- PHẦN MỚI: Chọn phương thức thanh toán --}}
                    <div class="p-4 bg-white rounded-3 shadow-sm mb-4" style="border: 1px solid #eae6df;">
                        <h5 class="text-uppercase fw-bold mb-3" style="font-size: 11px; letter-spacing: 1.5px; color: #555;">Phương thức thanh toán</h5>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method_choice" id="payment_cod" value="cod" data-action="{{ route('checkout.process') }}" checked>
                            <label class="form-check-label fw-bold text-dark" for="payment_cod" style="font-size: 14px; cursor: pointer;">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method_choice" id="payment_momo" value="momo" data-action="{{ route('momo.payment') }}">
                            <label class="form-check-label fw-bold text-danger" for="payment_momo" style="font-size: 14px; cursor: pointer;">
                                Thanh toán qua Ví MoMo (Mã QR)
                            </label>
                        </div>
                    </div>

                    {{-- Form thông tin cũ của bạn --}}
                    <div class="p-4 bg-white rounded-3 shadow-sm" style="border: 1px solid #eae6df;">
                        <h5 class="text-uppercase fw-bold mb-4" style="font-size: 11px; letter-spacing: 1.5px; color: #555;">Thông tin nhận hàng</h5>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Họ và tên người nhận <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="receiver_name" value="{{ old('receiver_name') }}" class="form-control bg-light border-0 py-3 px-3 custom-input" required>
                            @error('receiver_name')
                                <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Số điện thoại <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control bg-light border-0 py-3 px-3 custom-input" required>
                            @error('phone')
                                <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Địa chỉ giao hàng cụ thể <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control bg-light border-0 py-3 px-3 custom-input" required>
                            @error('address')
                                <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px; color: #444;">
                                Ghi chú đơn hàng (tùy chọn)
                            </label>
                            <textarea name="note" rows="3" class="form-control bg-light border-0 py-3 px-3 custom-input" placeholder="Ghi chú thêm về thời gian giao hàng...">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Cột phải: Tóm tắt đơn hàng hoặc Khung QR MoMo --}}
                <div class="col-lg-5">
                    @php $totalVal = $totalPrice ?? $total ?? 0; @endphp

                    {{-- 1. BẢNG TÓM TẮT ĐƠN HÀNG (Mặc định hiển thị cho COD) --}}
                    <div id="order-summary-box" class="p-4 bg-white rounded-3 shadow-sm mb-4" style="border: 1px solid #eae6df;">
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
                            <span class="fs-5 fw-bold text-dark">{{ number_format($totalVal) }} đ</span>
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

                    {{-- 2. KHUNG MÃ QR MOMO (Ẩn mặc định, hiện khi chọn MoMo) --}}
                    <div id="momo-qr-box" class="p-4 bg-white rounded-3 shadow-sm mb-4 text-center d-none" style="border: 1px solid #eae6df;">
                        <h5 class="text-uppercase fw-bold mb-3 text-danger" style="font-size: 12px; letter-spacing: 1.5px;">Thanh toán mã QR MoMo</h5>
                        <p class="text-muted mb-3" style="font-size: 12px;">Quét mã QR bằng ứng dụng MoMo của bạn</p>

                        <div class="my-3 p-3 bg-light rounded d-inline-block border">
                            @php
                                $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=MOMO_PAYMENT_" . $totalVal;
                            @endphp
                            <img id="momo-qr-img" src="{{ $qrUrl }}" alt="MoMo QR" class="img-fluid" style="width: 180px; height: 180px;">
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 mb-4 border-top">
                            <span class="text-uppercase fw-bold" style="font-size: 12px; letter-spacing: 1px;">Tổng thanh toán</span>
                            <span class="fs-5 fw-bold text-danger">{{ number_format($totalVal) }} đ</span>
                        </div>

                        <div class="d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-danger w-100 py-3 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1.5px; border-radius: 6px; background-color: #d82d8b; border: none;">
                                ✓ Xác nhận & Thanh toán MoMo
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

{{-- Script chuyển đổi Action của Form và ẩn hiện khung QR ở cột phải --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('.payment-method-radio');
        const form = document.getElementById('checkout-form');
        const orderSummaryBox = document.getElementById('order-summary-box');
        const momoQrBox = document.getElementById('momo-qr-box');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                // Đổi action của form dựa vào data-action của radio được chọn
                const targetAction = this.getAttribute('data-action');
                if (targetAction && form) {
                    form.action = targetAction;
                }

                // Chuyển đổi hiển thị bảng bên phải
                if (this.value === 'momo') {
                    orderSummaryBox.classList.add('d-none');
                    momoQrBox.classList.remove('d-none');
                } else {
                    momoQrBox.classList.add('d-none');
                    orderSummaryBox.classList.remove('d-none');
                }
            });
        });
    });
</script>

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