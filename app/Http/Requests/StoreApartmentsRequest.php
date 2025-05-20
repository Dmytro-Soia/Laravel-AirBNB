<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:300'],
            'rooms' => ['required', 'integer'],
            'max_people' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'photos' => ['required', 'array', 'min:3'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:10240'],
            'lat' => ['required', 'numeric'],
            'lon' => ['required', 'numeric'],
            'address' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        $address = explode(', ', $this->request->get('address'));
        $this->merge([
            'country' => $address[0],
            'city' => $address[1],
            'street' => $address[2],
        ]);
    }
}
