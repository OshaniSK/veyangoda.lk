<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RejectAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (bool) auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rejection_reason' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'rejection_reason.required' => 'Please provide a reason so the seller knows what to fix.',
            'rejection_reason.min'      => 'The rejection reason must be at least 10 characters long.',
            'rejection_reason.max'      => 'The rejection reason cannot exceed 1000 characters.',
        ];
    }
}
