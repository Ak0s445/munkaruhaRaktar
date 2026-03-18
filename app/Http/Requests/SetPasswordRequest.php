<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class SetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'A jelszó megadása kötelező.',
            'password.confirmed' => 'A jelszavaknak egyezniük kell.',
            'password.min' => 'A jelszónak legalább 6 karakter hosszúnak kell lennie.',
            'password.mixed' => 'A jelszónak tartalmaznia kell kis- és nagybetűt is.',
            'password.mixedCase' => 'A jelszónak tartalmaznia kell kis- és nagybetűt is.',
            'password.numbers' => 'A jelszónak tartalmaznia kell számot is.',
            'password.symbols' => 'A jelszónak tartalmaznia kell speciális karaktert is.',
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
