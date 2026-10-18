@extends('layouts.app') 

@section('title', 'Thanh toán đơn hàng') 

@section('content')
<div class="container py-4">
    <h2>Thông tin thanh toán</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    
    
    <div style="margin-bottom: 15px;">
        <label style="font-weight: 500; display: block; margin-bottom: 5px;">HỌ VÀ TÊN NGƯỜI NHẬN *</label>
        <input type="text" name="receiver_name" value="{{ old('receiver_name') }}" required 
               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="Ví dụ: Nguyen Van A">
        @error('receiver_name') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label style="font-weight: 500; display: block; margin-bottom: 5px;">SỐ ĐIỆN THOẠI *</label>
        <input type="text" name="phone" value="{{ old('phone') }}" required maxlength="10" 
               style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="Ví dụ: 0912345678">
        @error('phone') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
    </div>

    {{-- Ô địa chỉ chung đơn giản gọn gàng --}}
    <div style="margin-bottom: 15px;">
        <label style="font-weight: 500; display: block; margin-bottom: 5px;">ĐỊA CHỈ NHẬN HÀNG *</label>
        <input type="text" name="address" value="{{ old('address') }}" required 
            style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="Ví dụ: 123 Điện Biên Phủ, Phường 25, Bình Thạnh, TP.HCM">
        @error('address') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
    </div>

    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
        <div style="flex: 1;">
            <label style="font-weight: 500; display: block; margin-bottom: 5px;">XÃ / PHƯỜNG *</label>
            <input type="text" name="ward" value="{{ old('ward') }}" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="Ví dụ: Phường 25">
            @error('ward') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>
        <div style="flex: 1;">
            <label style="font-weight: 500; display: block; margin-bottom: 5px;">ĐỊA CHỈ CỤ THỂ (Số nhà, tên đường) *</label>
            <input type="text" name="address_detail" value="{{ old('address_detail') }}" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="Ví dụ: 123 Điện Biên Phủ">
            @error('address_detail') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="font-weight: 500; display: block; margin-bottom: 5px;">GHI CHÚ ĐƠN HÀNG (TÙY CHỌN)</label>
        <textarea name="note" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" rows="3">{{ old('note') }}</textarea>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkoutForm = document.getElementById('checkout-form');
    const paymentRadios = document.querySelectorAll('.payment-method-radio');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.checked) {
                // Lấy route tương ứng từ thuộc tính data-action
                const targetAction = this.getAttribute('data-action');
                
                // Cập nhật action cho form
                checkoutForm.setAttribute('action', targetAction);
                
                console.log('Action form đã đổi sang:', targetAction);
            }
        });
    });
});
</script>

