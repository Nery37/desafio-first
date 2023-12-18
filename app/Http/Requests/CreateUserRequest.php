<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O campo nome deve ter no mínimo :min caracteres.',
            'name.max' => 'O campo nome deve ter no máximo :max caracteres.',

            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',

            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.max' => 'A senha deve ter no máximo :max caracteres.',
            'password.confirmed' => 'A confirmação de senha não coincide.',
            'password_confirmation.required' => 'O campo de confirmação de senha é obrigatório.',
        ];
    }
}
