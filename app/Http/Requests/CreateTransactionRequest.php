<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999.99'
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    $category = \App\Models\Category::find($value);
                    if ($category && $category->user_id !== $this->user()->id) {
                        $fail('The selected category does not belong to you.');
                    }
                }
            ],
            'wallet_id' => [
                'required',
                'exists:wallets,id',
                function ($attribute, $value, $fail) {
                    $wallet = \App\Models\Wallet::find($value);
                    if ($wallet && $wallet->user_id !== $this->user()->id) {
                        $fail('The selected wallet does not belong to you.');
                    }
                }
            ],
            'expense_person_id' => [
                'nullable',
                'exists:expense_people,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $person = \App\Models\ExpensePerson::find($value);
                        if ($person && $person->user_id !== $this->user()->id) {
                            $fail('The selected person does not belong to you.');
                        }
                    }
                }
            ],
            'person_name' => [
                'nullable',
                'string',
                'max:255',
                'required_without:expense_person_id'
            ],
            'date' => [
                'nullable',
                'date',
                'before_or_equal:today',
                'after:' . now()->subYears(2)->format('Y-m-d')
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'type' => [
                'sometimes',
                'in:expense,income'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'The transaction amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The amount must be greater than 0.',
            'amount.max' => 'The amount cannot exceed 999,999.99.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'wallet_id.required' => 'Please select a wallet.',
            'wallet_id.exists' => 'The selected wallet is invalid.',
            'expense_person_id.exists' => 'The selected person is invalid.',
            'person_name.required_without' => 'Person name is required when no person is selected.',
            'person_name.max' => 'Person name cannot exceed 255 characters.',
            'date.date' => 'Please enter a valid date.',
            'date.before_or_equal' => 'The date cannot be in the future.',
            'date.after' => 'The date cannot be more than 2 years ago.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
            'type.in' => 'Transaction type must be either expense or income.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'amount' => 'transaction amount',
            'category_id' => 'category',
            'wallet_id' => 'wallet',
            'expense_person_id' => 'person',
            'person_name' => 'person name',
            'date' => 'transaction date',
            'notes' => 'notes',
            'type' => 'transaction type'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default type if not provided
        if (!$this->has('type')) {
            $this->merge(['type' => 'expense']);
        }

        // Set default date if not provided
        if (!$this->has('date') || empty($this->date)) {
            $this->merge(['date' => now()->format('Y-m-d')]);
        }

        // Clean up amount (remove currency symbols, commas, etc.)
        if ($this->has('amount')) {
            $amount = $this->amount;
            if (is_string($amount)) {
                // Remove currency symbols and thousand separators
                $amount = preg_replace('/[^\d\.\-]/', '', $amount);
                $this->merge(['amount' => $amount]);
            }
        }
    }
}
