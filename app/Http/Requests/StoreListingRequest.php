<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        foreach (['phone_number', 'whatsapp_number'] as $field) {
            $value = $this->input($field);
            if (is_string($value)) {
                $this->merge([
                    $field => preg_replace('/[\s().-]+/', '', $value),
                ]);
            }
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Sri Lanka phone number pattern: local (07x / 011) or international (+94 7x / +94 11)
        $phoneRegex = '/^(?:\+94(?:7\d{8}|11\d{7,8})|0(?:7\d{8}|11\d{7,8}))$/';

        return [
            'title'           => ['required', 'string', 'max:100'],
            'category_id'     => ['required', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'price'           => ['required', 'numeric', 'min:0'],
            'location'        => ['required', 'string', 'max:100'],
            'description'     => ['required', 'string', 'min:20', 'max:5000'],
            'images'          => ['required', 'array', 'min:1', 'max:5'],
            'images.*'        => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            // ── Seller contact details ────────────────────────────────────
            'contact_name'    => ['nullable', 'string', 'max:100'],
            'phone_number'    => ['required', 'string', 'max:20', 'regex:' . $phoneRegex],
            'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:' . $phoneRegex],
            'contact_email'   => ['nullable', 'email', 'max:150'],
            'show_phone'      => ['nullable', 'boolean'],
            'show_email'      => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom validation error messages for clean UX feedback.
     */
    public function messages(): array
    {
        return [
            'title.required'          => 'Please provide a descriptive title for your homemade item.',
            'title.max'               => 'The title must not exceed 100 characters.',
            'category_id.required'    => 'Please select an appropriate category.',
            'category_id.exists'      => 'The selected category is invalid.',
            'price.required'          => 'Please set a price for your item (enter 0 for free sample).',
            'price.numeric'           => 'The price must be a valid number.',
            'price.min'               => 'The price cannot be negative.',
            'location.required'       => 'Please enter your city or district.',
            'description.required'    => 'Please write a short description or story about this product.',
            'description.min'         => 'The description must be at least 20 characters long.',
            'description.max'         => 'The description cannot exceed 5000 characters.',
            'images.required'         => 'Please upload at least one photo of your item.',
            'images.min'              => 'Please upload at least one photo of your item.',
            'images.max'              => 'You can upload up to 5 photos.',
            'images.*.image'          => 'Each uploaded file must be a valid image.',
            'images.*.mimes'          => 'Accepted image formats are JPEG, PNG, JPG, and WEBP.',
            'images.*.max'            => 'Each image cannot exceed 2MB.',

            // ── Contact detail messages ───────────────────────────────────
            'phone_number.required'   => 'A contact phone number is required so buyers can reach you.',
            'phone_number.regex'      => 'Please enter a valid Sri Lankan phone number (e.g. 077 123 4567 or +94 77 123 4567).',
            'whatsapp_number.regex'   => 'Please enter a valid Sri Lankan WhatsApp number (e.g. 077 123 4567).',
            'contact_email.email'     => 'Please enter a valid email address.',
        ];
    }

}
