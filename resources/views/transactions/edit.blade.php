<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Transaction') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen ">
        <div class="max-w-6xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600                                                                                                                                                                                     p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Edit Transaction</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2 flex-wrap">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-200 hover:text-white transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <a href="{{ route('transactions.index') }}" class="text-blue-200 hover:text-white transition-colors">
                                            Transactions
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">Edit</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Transaction Type Badge -->
                        <div class="flex items-center">
                            @if($transaction->type === 'income')
                                <div class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-800 dark:text-green-200 font-semibold">Income</span>
                                </div>
                            @else
                                <div class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-red-800 dark:text-red-200 font-semibold">Expense</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wallet Balance Summary -->
            @if($wallets->count() > 0)
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Available Wallets
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($wallets as $wallet)
                            <div class="p-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $wallet->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $wallet->type->name ?? 'Wallet' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg text-green-600 dark:text-green-400">
                                            {{ $wallet->currency->symbol }}{{ number_format($wallet->balance, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Form Section -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-600 p-4 sm:p-6">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Transaction Details</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your transaction information</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 sm:p-6 lg:p-8">
                            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" x-data="transactionForm()" @submit="handleSubmit">
                                @csrf
                                @method('PUT')
                                
                                <div class="space-y-8">
                                    <!-- Transaction Type and Amount Section -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Type -->
                                        <div class="space-y-2">
                                            <label for="type" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Transaction Type
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <select name="type" id="type" required
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="expense" {{ old('type', $transaction->type) === 'expense' ? 'selected' : '' }}>
                                                    Expense
                                                </option>
                                                <option value="income" {{ old('type', $transaction->type) === 'income' ? 'selected' : '' }}>
                                                    Income
                                                </option>
                                            </select>
                                            @error('type')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Amount -->
                                        <div class="space-y-2">
                                            <label for="amount" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Amount
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="number" name="amount" id="amount" 
                                                   value="{{ old('amount', $transaction->amount) }}"
                                                   min="0" step="0.01" required
                                                   placeholder="0.00"
                                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm placeholder-gray-500 dark:placeholder-gray-400">
                                            @error('amount')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Category and Person Section -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Category -->
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <label for="category_id" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                    Category
                                                    <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">(Optional)</span>
                                                </label>
                                                <button type="button" onclick="openCategoryModal()"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-full hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Add New
                                                </button>
                                            </div>
                                            <select name="category_id" id="category_id"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="">No Category</option>
                                                @foreach ($categories->where('user_id', auth()->id()) as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Person -->
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <label for="expense_person_id" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                    Person
                                                    <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">(Optional)</span>
                                                </label>
                                                <button type="button" onclick="openPersonModal()"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-full hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Add New
                                                </button>
                                            </div>
                                            <select name="expense_person_id" id="expense_person_id"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="">No Person</option>
                                                @foreach ($people as $person)
                                                    <option value="{{ $person->id }}" {{ old('expense_person_id', $transaction->expense_person_id) == $person->id ? 'selected' : '' }}>
                                                        {{ $person->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('expense_person_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Wallet and Date Section -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Wallet -->
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <label for="wallet_id" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                    Wallet
                                                    <span class="text-red-500 ml-1">*</span>
                                                </label>
                                                <button type="button" onclick="openWalletModal()"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-full hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Add New
                                                </button>
                                            </div>
                                            <select name="wallet_id" id="wallet_id" required
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="">Select Wallet</option>
                                                @foreach ($wallets as $wallet)
                                                    <option value="{{ $wallet->id }}" {{ old('wallet_id', $transaction->wallet_id) == $wallet->id ? 'selected' : '' }}>
                                                        {{ $wallet->name }} ({{ $wallet->currency->symbol }}{{ number_format($wallet->balance, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('wallet_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Date -->
                                        <div class="space-y-2">
                                            <label for="date" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Transaction Date
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="date" name="date" id="date" 
                                                   value="{{ old('date', $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') : '') }}"
                                                   required max="{{ date('Y-m-d') }}"
                                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                            @error('date')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Note Section -->
                                    <div class="space-y-2">
                                        <label for="note" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                            Notes
                                            <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">(Optional)</span>
                                        </label>
                                        <textarea name="note" id="note" rows="4"
                                                  placeholder="Add any additional notes about this transaction..."
                                                  class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm resize-none placeholder-gray-500 dark:placeholder-gray-400">{{ old('note', $transaction->note) }}</textarea>
                                        @error('note')
                                            <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-600 space-y-4 sm:space-y-0">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="text-red-500">*</span> Required fields
                                        </div>
                                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                            <a href="{{ route('transactions.index') }}" 
                                               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Cancel
                                            </a>
                                            <button type="submit" 
                                                    :disabled="isSubmitting"
                                                    :class="isSubmitting ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 shadow-lg hover:shadow-xl transform hover:scale-105'"
                                                    class="inline-flex items-center justify-center px-8 py-3 text-white font-bold rounded-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 disabled:transform-none disabled:shadow-none">
                                                <span x-show="!isSubmitting" class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Update Transaction
                                                </span>
                                                <span x-show="isSubmitting" class="flex items-center">
                                                    <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Updating...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Transaction Tips -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-50 dark:from-blue-900 dark:to-blue-900 rounded-2xl border border-blue-200 dark:border-blue-700 p-6">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Edit Tips
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Double-check the amount and date before updating</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Add notes for better transaction tracking</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Categories help organize your expenses</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('transactions.show', $transaction->id) }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                View Transaction
                            </a>
                            <a href="{{ route('transactions.create') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New
                            </a>
                        </div>
                    </div>

                    <!-- Transaction Info -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Transaction Info
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">ID:</span>
                                <span class="font-medium text-gray-900 dark:text-white">#{{ $transaction->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Created:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Last Updated:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Original Amount:</span>
                                <span class="font-medium {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}₹{{ number_format($transaction->amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Modals with proper JavaScript -->
    <!-- Category Modal -->
    <div id="categoryModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Add New Category</h3>
                <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                    <input type="text" id="newCategoryName"
                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                           placeholder="Enter category name">
                </div>
                <div class="flex space-x-3">
                    <button onclick="closeCategoryModal()" 
                            class="flex-1 px-4 py-3 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitNewCategory()" 
                            class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors">
                        Add Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Person Modal -->
    <div id="personModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Add New Person</h3>
                <button onclick="closePersonModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Person Name</label>
                    <input type="text" id="newPersonName"
                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                           placeholder="Enter person name">
                </div>
                <div class="flex space-x-3">
                    <button onclick="closePersonModal()" 
                            class="flex-1 px-4 py-3 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitNewPerson()" 
                            class="flex-1 px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-xl transition-colors">
                        Add Person
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Wallet Modal -->
    <div id="walletModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Add New Wallet</h3>
                <button onclick="closeWalletModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Wallet Type</label>
                    <select id="newWalletType"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @foreach ($walletTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Wallet Name</label>
                    <input type="text" id="newWalletName"
                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                           placeholder="Enter wallet name" required>
                </div>
                @if ($currencies->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                        <select id="newWalletCurrency"
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->symbol }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Initial Balance</label>
                    <input type="number" id="newWalletBalance" value="0"
                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                           placeholder="Initial balance" min="0" step="0.01">
                </div>
                <div class="flex space-x-3">
                    <button onclick="closeWalletModal()" 
                            class="flex-1 px-4 py-3 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitNewWallet()" 
                            class="flex-1 px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-xl transition-colors">
                        Add Wallet
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function transactionForm() {
            return {
                isSubmitting: false,
                
                handleSubmit(event) {
                    this.isSubmitting = true;
                }
            }
        }

        // Fixed modal functions
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.getElementById('newCategoryName').value = '';
        }

        function submitNewCategory() {
            const name = document.getElementById('newCategoryName').value.trim();

            if (!name) {
                alert("Please enter a category name");
                return;
            }

            fetch('{{ route('categories.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('category_id');
                    const option = document.createElement('option');
                    option.value = data.category.id;
                    option.text = data.category.name;
                    option.selected = true;
                    select.appendChild(option);

                    closeCategoryModal();
                } else {
                    alert("Error adding category: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error adding category");
            });
        }

        function openPersonModal() {
            document.getElementById('personModal').classList.remove('hidden');
        }

        function closePersonModal() {
            document.getElementById('personModal').classList.add('hidden');
            document.getElementById('newPersonName').value = '';
        }

        function submitNewPerson() {
            const name = document.getElementById('newPersonName').value.trim();

            if (!name) {
                alert("Please enter a person name");
                return;
            }

            fetch('{{ route('expense-people.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('expense_person_id');
                    const option = document.createElement('option');
                    option.value = data.person.id;
                    option.text = data.person.name;
                    option.selected = true;
                    select.appendChild(option);

                    closePersonModal();
                } else {
                    alert("Error adding person: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error adding person");
            });
        }

        function openWalletModal() {
            document.getElementById('walletModal').classList.remove('hidden');
        }

        function closeWalletModal() {
            document.getElementById('walletModal').classList.add('hidden');
            document.getElementById('newWalletName').value = '';
            document.getElementById('newWalletBalance').value = '0';
        }

        function submitNewWallet() {
            const walletType = document.getElementById('newWalletType').value;
            const name = document.getElementById('newWalletName').value.trim();
            const currency = document.getElementById('newWalletCurrency').value;
            const balance = document.getElementById('newWalletBalance').value || 0;

            if (!walletType || !name || !currency) {
                alert("Please fill in all required fields");
                return;
            }

            fetch('{{ route('wallets.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    wallet_type_id: walletType,
                    currency_id: currency,
                    name,
                    balance: parseFloat(balance),
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('wallet_id');
                    const option = document.createElement('option');
                    option.value = data.wallet.id;
                    option.text = `${data.wallet.name} (${data.wallet.currency.symbol}${Number(data.wallet.balance).toFixed(2)})`;
                    option.selected = true;
                    select.appendChild(option);

                    closeWalletModal();
                } else {
                    alert("Error adding wallet: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error adding wallet");
            });
        }

        // Set today's date as default if no date is set
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            if (!dateInput.value) {
                dateInput.value = new Date().toISOString().split('T')[0];
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const categoryModal = document.getElementById('categoryModal');
            const personModal = document.getElementById('personModal');
            const walletModal = document.getElementById('walletModal');

            if (event.target === categoryModal) {
                closeCategoryModal();
            }
            if (event.target === personModal) {
                closePersonModal();
            }
            if (event.target === walletModal) {
                closeWalletModal();
            }
        });

        // Close modals with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCategoryModal();
                closePersonModal();
                closeWalletModal();
            }
        });
    </script>

</x-app-layout>