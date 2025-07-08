<x-app-layout>
    <x-slot name="title">
        {{ __('Create Wallet') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-scree">
        <div class="max-w-6xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Create New Wallet</h1>
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
                                        <a href="{{ route('wallets.index') }}" class="text-blue-200 hover:text-white transition-colors">
                                            Wallets
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">Create Wallet</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Current Time Display -->
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Today</p>
                                <p class="text-lg font-bold text-white">Jul 07, 2025</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-600 p-4 sm:p-6">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">New Wallet Details</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Enter the wallet information below</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 sm:p-6 lg:p-8">
                            <form action="{{ route('wallets.store') }}" method="POST" x-data="walletForm()" @submit="handleSubmit">
                                @csrf

                                <div class="space-y-6">

                                    <!-- Form Fields -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Wallet Type -->
                                        <div class="space-y-2">
                                            <label for="wallet_type_id" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Wallet Type
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <select name="wallet_type_id" id="wallet_type_id" required x-model="selectedType"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="">Select Wallet Type</option>
                                                @foreach ($walletTypes as $type)
                                                    <option value="{{ $type->id }}" {{ old('wallet_type_id') == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('wallet_type_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Wallet Name -->
                                        <div class="space-y-2">
                                            <label for="name" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Wallet Name
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name" 
                                                   value="{{ old('name') }}"
                                                   required 
                                                   maxlength="255"
                                                   placeholder="Enter wallet name (e.g., My Checking Account, Cash Wallet)"
                                                   x-model="walletName"
                                                   x-ref="nameInput"
                                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm placeholder-gray-500 dark:placeholder-gray-400">
                                            @error('name')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Initial Balance -->
                                        <div class="space-y-2">
                                            <label for="balance" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Initial Balance
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="number" 
                                                   name="balance" 
                                                   id="balance" 
                                                   value="{{ old('balance', 0) }}"
                                                   min="0" 
                                                   step="0.01" 
                                                   required
                                                   placeholder="0.00"
                                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm placeholder-gray-500 dark:placeholder-gray-400">
                                            @error('balance')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Currency -->
                                        <div class="space-y-2">
                                            <label for="currency_id" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Currency
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <select name="currency_id" id="currency_id" required
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="">Select Currency</option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                                        {{ $currency->name }} ({{ $currency->code }}) - {{ $currency->symbol }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('currency_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status Toggle -->
                                    <div class="space-y-2">
                                        <label class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                            Wallet Status
                                        </label>
                                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600">
                                            <input type="checkbox" 
                                                   name="is_active" 
                                                   id="is_active" 
                                                   value="1" 
                                                   {{ old('is_active', true) ? 'checked' : '' }}
                                                   class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-1 dark:bg-gray-800 dark:border-gray-600">
                                            <label for="is_active" class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Make this wallet active immediately
                                            </label>
                                            @error('is_active')
                                                <p class="text-sm text-red-700 dark:text-red-400 ml-3">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Active wallets can be used for transactions</p>
                                    </div>

                                    <!-- Suggestions -->
                                    <div class="bg-blue-50 dark:bg-blue-900 rounded-xl p-4 border border-blue-200 dark:border-blue-700">
                                        <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-2">Common Wallet Names</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" 
                                                    @click="walletName = 'Main Checking Account'; $refs.nameInput.focus()"
                                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-full hover:bg-blue-200 dark:hover:bg-blue-700 transition-colors">
                                                Main Checking Account
                                            </button>
                                            <button type="button" 
                                                    @click="walletName = 'Cash Wallet'; $refs.nameInput.focus()"
                                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-full hover:bg-blue-200 dark:hover:bg-blue-700 transition-colors">
                                                Cash Wallet
                                            </button>
                                            <button type="button" 
                                                    @click="walletName = 'Savings Account'; $refs.nameInput.focus()"
                                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-full hover:bg-blue-200 dark:hover:bg-blue-700 transition-colors">
                                                Savings Account
                                            </button>
                                            <button type="button" 
                                                    @click="walletName = 'Credit Card'; $refs.nameInput.focus()"
                                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-full hover:bg-blue-200 dark:hover:bg-blue-700 transition-colors">
                                                Credit Card
                                            </button>
                                            <button type="button" 
                                                    @click="walletName = 'Digital Wallet'; $refs.nameInput.focus()"
                                                    class="px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-full hover:bg-blue-200 dark:hover:bg-blue-700 transition-colors">
                                                Digital Wallet
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Hidden User ID -->
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                    <!-- Form Actions -->
                                    <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-600 space-y-4 sm:space-y-0">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="text-red-500">*</span> Required fields
                                        </div>
                                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                            <a href="{{ route('wallets.index') }}" 
                                               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Cancel
                                            </a>
                                            <button type="submit" 
                                                    :disabled="isSubmitting || !walletName.trim()"
                                                    :class="(isSubmitting || !walletName.trim()) ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:scale-105'"
                                                    class="inline-flex items-center justify-center px-8 py-3 text-white font-bold rounded-xl transition-all duration-200 focus:outline-none focus:ring-1 disabled:transform-none disabled:shadow-none">
                                                <span x-show="!isSubmitting" class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Create Wallet
                                                </span>
                                                <span x-show="isSubmitting" class="flex items-center">
                                                    <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Creating...
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
                    <!-- Creation Tips -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-50 dark:from-blue-900 dark:to-blue-900 rounded-2xl border border-blue-200 dark:border-blue-700 p-6">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Wallet Tips
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Choose descriptive names for easy identification</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Set the correct initial balance for accurate tracking</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Select the appropriate currency for each wallet</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Active wallets appear in transaction forms</p>
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
                            <a href="{{ route('wallets.index') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View All Wallets
                            </a>
                            <a href="{{ route('transactions.create') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Add Transaction
                            </a>
                            <a href="{{ route('dashboard') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        function walletForm() {
            return {
                isSubmitting: false,
                walletName: '{{ old('name', '') }}',
                
                handleSubmit(event) {
                    this.isSubmitting = true;
                }
            }
        }

        // Auto-focus the name field
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            if (nameInput) {
                nameInput.focus();
            }
        });
    </script>
    
</x-app-layout>