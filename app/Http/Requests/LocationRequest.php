<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LocationRequest extends FormRequest
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
            'building' => ['required', 'string', 'max:255'],
            'row' => ['required', 'string', 'max:255'],
            'shelf' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'building.required' => 'Az épület megadása kötelező.',
            'building.string' => 'Az épület csak szöveg lehet.',
            'building.max' => 'Az épület túl hosszú (max. 255 karakter).',

            'row.required' => 'A sor megadása kötelező.',
            'row.string' => 'A sor csak szöveg lehet.',
            'row.max' => 'A sor túl hosszú (max. 255 karakter).',

            'shelf.required' => 'A polc megadása kötelező.',
            'shelf.string' => 'A polc csak szöveg lehet.',
            'shelf.max' => 'A polc túl hosszú (max. 255 karakter).',
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
