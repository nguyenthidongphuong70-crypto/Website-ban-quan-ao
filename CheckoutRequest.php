<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod,banking',
        ];
    }
}