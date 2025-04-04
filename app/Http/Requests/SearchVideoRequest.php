<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchVideoRequest extends FormRequest
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
            'query' => 'required|string|max:255',
            'per_page' => 'sometimes|integer|min:1|max:80',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'query.required' => 'O campo :attribute é obrigatório.',
            'query.string' => 'O campo :attribute deve ser uma string.',
            'query.max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'per_page.integer' => 'O campo :attribute deve ser um número inteiro.',
            'per_page.min' => 'O campo :attribute deve ser pelo menos :min.',
            'per_page.max' => 'O campo :attribute não pode ser maior que :max.',
        ];
    }
}
