<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'size' => ['required', 'in:XS,S,M,L,XL,XXL'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A termék neve kötelező.',
            'name.string' => 'A termék neve szöveg kell legyen.',
            'name.max' => 'A termék neve túl hosszú (max. 255 karakter).',

            'description.string' => 'A leírás szöveg kell legyen.',

            'category_id.required' => 'A kategória megadása kötelező.',
            'category_id.integer' => 'A kategória azonosítója csak szám lehet.',
            'category_id.exists' => 'A megadott kategória nem létezik.',

            'location_id.required' => 'A hely megadása kötelező.',
            'location_id.integer' => 'A hely azonosítója csak szám lehet.',
            'location_id.exists' => 'A megadott hely nem létezik.',

            'quantity.required' => 'A mennyiség megadása kötelező.',
            'quantity.numeric' => 'A mennyiség csak szám lehet.',
            'quantity.min' => 'A mennyiség nem lehet negatív.',

            'size.required' => 'A méret megadása kötelező.',
            'size.in' => 'A méret csak ezek egyike lehet: XS, S, M, L, XL, XXL.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Adatbeviteli hiba',
            'data' => $validator->errors(),
        ], 422));
    }
}
