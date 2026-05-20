<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'provider_id' => ['required', 'integer', 'exists:providers,id'],
            'storage_id' => ['required', 'integer', 'exists:storages,id'],
            'purchased_at' => ['sometimes', 'date', 'before_or_equal:today'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.id' => ['required', 'integer', 'exists:products,id', 'distinct'],
            'products.*.qty' => ['required', 'integer', 'min:1'],
            'products.*.unit_cost' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
