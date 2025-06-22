<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Wallet') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full max-w-2xl mx-auto sm:px-4">
            <x-bread-crumb-navigation />

            <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <form action="{{ route('wallets.update', $wallet->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Wallet Type -->
                    <div class="mb-4">
                        <label for="wallet_type_id" class="block text-sm font-semibold text-gray-700">Wallet Type</label>
                        <select name="wallet_type_id" id="wallet_type_id" class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm" required>
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
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $wallet->name) }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm" required>
                        @error('name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Balance -->
                    <div class="mb-4">
                        <label for="balance" class="block text-sm font-semibold text-gray-700">Balance</label>
                        <input type="number" name="balance" id="balance" value="{{ old('balance', $wallet->balance) }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm" min="0" step="0.01" required>
                        @error('balance')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div class="mb-4">
                        <label for="currency_id" class="block text-sm font-semibold text-gray-700">Currency</label>
                        <select name="currency_id" id="currency_id" class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm" required>
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
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="mr-2" {{ old('is_active', $wallet->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-semibold text-gray-700">Active</label>
                    </div>

                    <!-- Hidden User ID -->
                    <input type="hidden" name="user_id" value="{{ $wallet->user_id }}">

                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 text-lg font-semibold text-white transition duration-300 rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600">
                            Update Wallet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
