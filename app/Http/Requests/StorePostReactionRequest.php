<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostReactionRequest extends FormRequest
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
            'reaction' => ['required', 'in:like,dislike'],
        ];
    }

    public function messages(): array
    {
        return [
            'reaction.required' => 'Wybierz reakcję.',
            'reaction.in' => 'Nieprawidłowa reakcja.',
        ];
    }
}
