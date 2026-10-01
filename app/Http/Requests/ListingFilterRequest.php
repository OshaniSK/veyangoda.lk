<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public discovery filter is open to all visitors
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:100'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'gte:min_price'],
            'condition' => ['nullable', 'in:made_to_order,ready_stock,custom_handcrafted'],
            'sort' => ['nullable', 'in:latest,price_asc,price_desc,popular'],
        ];
    }
}
