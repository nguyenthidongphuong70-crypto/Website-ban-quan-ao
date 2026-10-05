<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'size'        => ['nullable', 'string', 'max:10'],
            'color'       => ['nullable', 'string', 'max:50'],
            'stock'       => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.exists'   => 'Danh mục đã chọn không tồn tại trong hệ thống.',
            'name.required'        => 'Tên sản phẩm không được để trống.',
            'name.max'             => 'Tên sản phẩm không được vượt quá 150 ký tự.',
            'price.required'       => 'Giá sản phẩm không được để trống.',
            'price.numeric'        => 'Giá sản phẩm phải là chữ số.',
            'price.min'            => 'Giá sản phẩm không được nhỏ hơn 0.',
            'stock.required'       => 'Số lượng tồn kho không được để trống.',
            'stock.integer'        => 'Số lượng tồn kho phải là số nguyên.',
            'stock.min'            => 'Số lượng tồn kho không được nhỏ hơn 0.',
            'image.image'          => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes'          => 'Hình ảnh phải có định dạng: jpeg, png, jpg, webp.',
            'image.max'            => 'Kích thước ảnh tối đa không quá 2MB.',
            'size.max'             => 'Kích cỡ (size) không quá 10 ký tự.',
            'color.max'            => 'Màu sắc không quá 50 ký tự.',
        ];
    }
}
