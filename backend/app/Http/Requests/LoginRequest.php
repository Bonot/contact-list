<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'email.required' => 'Informe um email.',
            'email.email' => 'Informe um email válido.',
            'password.required' => 'Informe uma senha.',
        ];
    }
}
