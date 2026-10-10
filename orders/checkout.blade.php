@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Thông tin thanh toán</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Form nhập thông tin người nhận -->
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-sm p-4">
                    <h4 class="mb-3 fw-semibold">Địa chỉ nhận hàng</h4>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên người nhận *</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại *</label>
                        <input type="text" class="form-control" id="phone" name="phone" required value="{{ old('phone') }}">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ giao hàng cụ thể *</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea class="form-control" id="note" name="note" rows="2">{{ old('note') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tổng kết giỏ hàng và nút Tạo đơn hàng -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm bg-light p-4">
                    <h4 class="mb-3 fw-semibold">Đơn hàng của bạn</h4>
                    <ul class="list-group mb-3">
                        @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ $item->product->name ?? 'Sản phẩm' }}</h6>
                                    <small class="text-muted">SL: {{ $item->quantity }}</small>
                                </div>
                                <span class="text-muted">
                                    {{ number_format($item->quantity * ($item->product->sale_price ?? $item->product->price ?? 0)) }} đ
                                </span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between bg-white">
                            <span class="fw-bold">Tổng thanh toán</span>
                            <strong class="text-danger fs-5">{{ number_format($total ?? 0) }} đ</strong>
                        </li>
                    </ul>

                    <button type="submit" class="btn btn-dark w-100 py-3 fw-bold text-uppercase">Đặt hàng ngay</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection