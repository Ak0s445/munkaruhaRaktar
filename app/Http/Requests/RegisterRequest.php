<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:3,16', 'unique:users,name', 'doesnt_start_with:_'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

            'full_name' => ['required', 'string', 'max:70'],
            'city' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'birth_date' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A név megadása kötelező.',
            'name.string' => 'A név csak szöveg lehet.',
            'name.between' => 'A név hossza 3 és 16 karakter között kell legyen.',
            'name.unique' => 'Ez a felhasználónév már foglalt.',
            'name.doesnt_start_with' => 'A név nem kezdődhet alulvonással.',

            'email.required' => 'Az email cím megadása kötelező.',
            'email.email' => 'Az email cím formátuma érvénytelen.',
            'email.unique' => 'Ez az email cím már foglalt.',

            'password.required' => 'A jelszó megadása kötelező.',
            'password.confirmed' => 'A jelszavaknak egyezniük kell.',

            'full_name.required' => 'A teljes név megadása kötelező.',
            'full_name.string' => 'A teljes név csak szöveg lehet.',
            'full_name.max' => 'A teljes név legfeljebb 70 karakter lehet.',

            'city.string' => 'A város neve csak szöveg lehet.',
            'city.max' => 'A város neve legfeljebb 50 karakter lehet.',

            'address.string' => 'A cím csak szöveg lehet.',
            'address.max' => 'A cím legfeljebb 100 karakter lehet.',

            'phone_number.string' => 'A telefonszám csak szöveg lehet.',
            'phone_number.max' => 'A telefonszám legfeljebb 25 karakter lehet.',

            'birth_date.date' => 'A születési dátum formátuma érvénytelen.',
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
