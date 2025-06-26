<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Wallet') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full h-auto mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-6 rounded-2xl shadow m-4 flex flex-col">
            <!-- Breadcrumb -->
            <div class="flex justify-between items-center mb-4">
                <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('wallets.index') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                </svg>
                                Wallets
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Edit Wallet</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Form -->
            <form action="{{ route('wallets.update', $wallet->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Wallet Type -->
                <div class="mb-5 mt-3">
                    <label for="wallet_type_id" class="block text-sm font-semibold text-gray-700">Wallet Type</label>
                    <select name="wallet_type_id" id="wallet_type_id"
                        class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="">Select Type</option>
                        @foreach ($walletTypes as $type)
                            <option value="{{ $type->id }}" {{ old('wallet_type_id', $wallet->wallet_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('wallet_type_id')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $wallet->name) }}"
                        class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required maxlength="255">
                    @error('name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Balance -->
                <div class="mb-5">
                    <label for="balance" class="block text-sm font-semibold text-gray-700">Balance</label>
                    <input type="number" name="balance" id="balance" value="{{ old('balance', $wallet->balance) }}"
                        class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        min="0" step="0.01" required>
                    @error('balance')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Currency -->
                <div class="mb-5">
                    <label for="currency_id" class="block text-sm font-semibold text-gray-700">Currency</label>
                    <select name="currency_id" id="currency_id"
                        class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="">Select Currency</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ old('currency_id', $wallet->currency_id) == $currency->id ? 'selected' : '' }}>
                                {{ $currency->name }} ({{ $currency->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('currency_id')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="mb-5 flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        class="mr-2" {{ old('is_active', $wallet->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm font-semibold text-gray-700">Active</label>
                    @error('is_active')
                        <span class="text-sm text-red-600 ml-2">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Hidden User ID -->
                <input type="hidden" name="user_id" value="{{ $wallet->user_id }}">

                <div class="flex justify-end">
                    <x-primary-button>
                        {{ __('Update Wallet') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
