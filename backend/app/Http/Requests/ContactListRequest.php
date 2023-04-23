<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ContactListRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'contacts' => 'required|array',
            'contacts.*.contact_type_id' => 'required|integer|exists:contact_types,id',
            'contacts.*.value' => 'required|string',
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
            'name.required' => 'Informe um nome',
            'name.string' => 'O nome deve ser uma string',

            'contacts.required' => 'Informe um contato.',
            'contacts.array' => 'Os contatos devem ser um array.',

            'contacts.*.contact_type_id.required' => 'Informe todos os tipos de contato.',
            'contacts.*.contact_type_id.integer' => 'Tipo de contato inválido.',
            'contacts.*.contact_type_id.exists' => 'Tipo de contato inválido.',

            'contacts.*.value.required' => 'Informe o contato',
            'contacts.*.value.string' => 'O contato deve ser uma string.',
        ];
    }
}
