@extends('layouts.app') 

@section('title', 'Thanh toán đơn hàng') 

@section('content')
<div class="container py-4">
    <h2>Thông tin thanh toán</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Cột bên trái: Nhập thông tin giao hàng -->
            <div class="col-md-7">
                <h4>Địa chỉ nhận hàng</h4>
                
                <div class="mb-3">
                    <label>Họ và tên người nhận *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label>Số điện thoại *</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label>Địa chỉ giao hàng cụ thể *</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                </div>

                <div class="mb-3">
                    <label>Ghi chú đơn hàng (tùy chọn)</label>
                    <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                </div>
            </div>

            <!-- Cột bên phải: Tóm tắt đơn hàng và sản phẩm -->
            <div class="col-md-5">
                <div class="card p-3">
                    <h4>Đơn hàng của bạn</h4>
                    <hr>
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="my-0">{{ $item->product->name ?? 'Sản phẩm' }}</h6>
                                    <small class="text-muted">SL: {{ $item->quantity }} | Size: {{ $item->product->size ?? '—' }}</small>
                                </div>
                                <span>{{ number_format($item->quantity * ($item->product->sale_price ?? $item->product->price ?? 0), 0, ',', '.') }} đ</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Tổng thanh toán:</strong>
                        <strong class="text-danger fs-5">{{ number_format($total ?? 0, 0, ',', '.') }} đ</strong>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-2">Đặt hàng ngay</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

