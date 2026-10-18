@extends('layouts.app')

@section('content')
<div class="container text-center my-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px; border-radius: 12px; border: 1px solid #eae6df;">
        <h3 class="mb-3 text-danger fw-bold" style="color: #d82d8b !important;">Quét mã QR thanh toán MoMo</h3>
        <p class="text-muted" style="font-size: 13px;">Sử dụng ứng dụng MoMo để quét mã bên dưới</p>

        {{-- Khung hiển thị ảnh QR căn giữa gọn gàng --}}
        <div class="my-3 p-3 bg-light rounded border d-flex justify-content-center align-items-center mx-auto" style="width: fit-content;">
            <img src="{{ $qrCodeUrl }}" 
                 alt="MoMo QR Code" 
                 class="img-fluid" 
                 style="width: 200px; height: 200px; object-fit: contain; display: block;">
        </div>

        <div class="my-3">
            <span class="text-dark">Số tiền: </span>
            <strong class="text-danger fs-5" style="color: #d82d8b !important;">{{ number_format($amount) }} VNĐ</strong>
        </div>

        <div class="d-grid gap-2 col-10 mx-auto">
            <a href="{{ $payUrl }}" target="_blank" class="btn btn-danger py-2 fw-bold text-uppercase" style="background-color: #d82d8b; border: none; font-size: 13px; letter-spacing: 0.5px;">
                Mở trang thanh toán MoMo
            </a>
            <a href="{{ route('checkout.index') }}" class="btn btn-link text-muted text-decoration-none" style="font-size: 13px;">
                Quay lại trang thanh toán
            </a>
        </div>
    </div>
</div>
@endsection