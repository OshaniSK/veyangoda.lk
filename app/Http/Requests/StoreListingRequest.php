<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
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
        return [
            'title' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'location' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'images' => ['required', 'array', 'min:1', 'max:5'],
            'images.*' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    /**
     * Custom validation error messages for clean UX feedback.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a descriptive title for your homemade item.',
            'title.max' => 'The title must not exceed 100 characters.',
            'category_id.required' => 'Please select an appropriate category.',
            'category_id.exists' => 'The selected category is invalid.',
            'price.required' => 'Please set a price for your item (enter 0 for free sample).',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price cannot be negative.',
            'location.required' => 'Please enter your city or district.',
            'description.required' => 'Please write a short description or story about this product.',
            'description.min' => 'The description must be at least 20 characters long.',
            'description.max' => 'The description cannot exceed 5000 characters.',
            'images.required' => 'Please upload at least one photo of your item.',
            'images.min' => 'Please upload at least one photo of your item.',
            'images.max' => 'You can upload up to 5 photos.',
            'images.*.image' => 'Each uploaded file must be a valid image.',
            'images.*.mimes' => 'Accepted image formats are JPEG, PNG, JPG, and WEBP.',
            'images.*.max' => 'Each image cannot exceed 2MB.',
        ];
    }
}
