<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'quantity' => 'nullable|integer|min:1',
        ];
    }

    
    public function messages(): array
    {
        return [
            'quantity.integer' => 'Số lượng sản phẩm phải là một số nguyên.',
            'quantity.min' => 'Số lượng sản phẩm thêm vào giỏ ít nhất phải là 1.',
        ];
    }
}
