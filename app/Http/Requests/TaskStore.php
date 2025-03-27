<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStore extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'required',
                'string',
                'max:255'
            ],
            'status' => [
                'required',
                'string',
                'in:pending,completed'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Task adı zorunludur.',
            'name.string' => 'Task adı metin olmalıdır.',
            'name.max' => 'Task adı en fazla 255 karakter olmalıdır.',
            'description.required' => 'Açıklama zorunludur.',
            'description.string' => 'Açıklama metin olmalıdır.',
            'description.max' => 'Açıklama en fazla 255 karakter olmalıdır.',
            'status.required' => 'Durum zorunludur.',
            'status.string' => 'Durum metin olmalıdır.',
            'status.in' => 'Durum sadece bekliyor ya da tamamlandı olabilir.'
        ];
    }
}
