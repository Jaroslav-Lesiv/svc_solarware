<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRefundRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'products'       => ['required', 'array', 'min:1'],
            'products.*.id'  => ['required', 'integer', 'exists:products,id', 'distinct'],
            'products.*.qty' => ['required', 'integer', 'min:1'],
        ];
    }
}
