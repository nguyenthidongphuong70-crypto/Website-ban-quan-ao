<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này hay không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các quy tắc kiểm tra dữ liệu (validation rules) đầu vào.
     */
    public function rules(): array
    {
        return [
            'quantity' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (nếu muốn).
     */
    public function messages(): array
    {
        return [
            'quantity.integer' => 'Số lượng sản phẩm phải là một số nguyên.',
            'quantity.min' => 'Số lượng sản phẩm thêm vào giỏ ít nhất phải là 1.',
        ];
    }
}