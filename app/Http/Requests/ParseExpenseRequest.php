<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParseExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'message' => [
                'required',
                'string',
                'max:1000',
                'min:3'
            ],
            'user_id' => [
                'sometimes',
                'exists:users,id'
            ],
            'context' => [
                'sometimes',
                'array'
            ],
            'context.recent_transactions' => [
                'sometimes',
                'boolean'
            ],
            'context.include_suggestions' => [
                'sometimes',
                'boolean'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'message.required' => 'The expense message is required.',
            'message.string' => 'The expense message must be a string.',
            'message.max' => 'The expense message may not be greater than 1000 characters.',
            'message.min' => 'The expense message must be at least 3 characters.',
            'user_id.exists' => 'The specified user does not exist.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'message' => 'expense message',
            'user_id' => 'user ID'
        ];
    }
}
