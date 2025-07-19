<x-app-layout>
    <x-slot name="title">
        {{ __('Transfer Funds') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-2xl mx-auto py-10">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Transfer Funds Between Wallets</h1>
                </div>
                <div class="p-6">
                    <form action="{{ route('wallets.transfer') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="from_wallet_id" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                From Wallet <span class="text-red-500">*</span>
                            </label>
                            <select name="from_wallet_id" id="from_wallet_id" required
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800">
                                <option value="">Select Wallet</option>
                                @foreach ($wallets as $wallet)
                                    <option value="{{ $wallet->id }}" {{ old('from_wallet_id') == $wallet->id ? 'selected' : '' }}>
                                        {{ $wallet->name }} ({{ $wallet->balance }} {{ $wallet->currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('from_wallet_id')
                                <p class="text-sm text-red-700 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="to_wallet_id" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                To Wallet <span class="text-red-500">*</span>
                            </label>
                            <select name="to_wallet_id" id="to_wallet_id" required
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800">
                                <option value="">Select Wallet</option>
                                @foreach ($wallets as $wallet)
                                    <option value="{{ $wallet->id }}" {{ old('to_wallet_id') == $wallet->id ? 'selected' : '' }}>
                                        {{ $wallet->name }} ({{ $wallet->balance }} {{ $wallet->currency->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('to_wallet_id')
                                <p class="text-sm text-red-700 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="amount" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="amount" id="amount" min="0.01" step="0.01" required
                                value="{{ old('amount') }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800">
                            @error('amount')
                                <p class="text-sm text-red-700 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('wallets.index') }}"
                               class="inline-flex items-center px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 font-medium mr-4">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-8 py-3 text-white font-bold rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg">
                                Transfer Funds
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
