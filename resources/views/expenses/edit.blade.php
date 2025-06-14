<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Expense / Income') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6 ml-4 sm:ml-64">
        <div class="w-full max-w-4xl px-6 mx-auto">
            <x-bread-crumb-navigation />

            <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <div class="mb-4 text-sm text-gray-600">
                    <strong>Available Cash:</strong> ₹{{ number_format($balance->cash, 2) }}<br>
                    <strong>Available Bank:</strong> ₹{{ number_format($balance->bank, 2) }}
                </div>

                <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-semibold text-gray-700">Type</label>
                        <select name="type" id="type"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="expense" {{ old('type', $expense->type) === 'expense' ? 'selected' : '' }}>Expense</option>
                            <option value="income" {{ old('type', $expense->type) === 'income' ? 'selected' : '' }}>Income</option>
                        </select>
                        @error('type')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-semibold text-gray-700">Category</label>
                        <select name="category_id" id="category_id"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">None</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Expense Person -->
                    <div class="mb-4">
                        <label for="expense_person_id" class="block text-sm font-semibold text-gray-700">Expense Person</label>
                        <select name="expense_person_id" id="expense_person_id"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">None</option>
                            @foreach($people as $person)
                                <option value="{{ $person->id }}" {{ old('expense_person_id', $expense->expense_person_id) == $person->id ? 'selected' : '' }}>
                                    {{ $person->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('expense_person_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-semibold text-gray-700">Amount</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            min="0" step="0.01" required>
                        @error('amount')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-4">
                        <label for="payment_method" class="block text-sm font-semibold text-gray-700">Payment Method</label>
                        <select name="payment_method" id="payment_method"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="cash" {{ old('payment_method', $expense->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank" {{ old('payment_method', $expense->payment_method) === 'bank' ? 'selected' : '' }}>Bank</option>
                        </select>
                        @error('payment_method')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label for="date" class="block text-sm font-semibold text-gray-700">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date', $expense->date ? $expense->date : '') }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('date')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Note -->
                    <div class="mb-4">
                        <label for="note" class="block text-sm font-semibold text-gray-700">Note</label>
                        <textarea name="note" id="note" rows="3"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('note', $expense->note) }}</textarea>
                        @error('note')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 text-lg font-semibold text-white transition duration-300 rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
