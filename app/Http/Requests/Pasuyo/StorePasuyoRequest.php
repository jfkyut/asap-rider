<?php

namespace App\Http\Requests\Pasuyo;

use Illuminate\Foundation\Http\FormRequest;

class StorePasuyoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location' => 'required|string|max:255',
            'location_coordinates' => 'nullable',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'note' => 'nullable|string',
            'content' => 'required|string',
            'budget' => 'numeric|min:0|nullable',
            'status' => 'required|string|max:50',
            'payment_method' => 'required|string|max:100',
            'attachments' => 'nullable', // Max 10MB per file
        ];
    }
}
