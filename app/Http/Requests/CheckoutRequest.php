<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'dates' => ['required'],
            'guest_number' => ['required'],
            'reserved_at' => ['required', 'date', 'after:today'],
            'expired_at' => ['required', 'date', 'after_or_equal:reserved_at'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'reserved_at' => explode(' to ', $this->dates)[0] ?? '',
            'expired_at' => explode(' to ', $this->dates)[1] ?? '',
        ]);
    }
}
