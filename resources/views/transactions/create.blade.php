<x-app-layout>
    <x-slot name="title">
        {{ __('Transaction Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-4xl sm:px-6 lg:px-8 bg-white p-6 rounded-2xl shadow m-4 flex flex-col">
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
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                </svg>
                                Transactions
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Transaction Details</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Transaction Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Type</label>
                    <div class="mt-1 text-base text-gray-900">{{ ucfirst($transaction->type) }}</div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Category</label>
                    <div class="mt-1 text-base text-gray-900">{{ $transaction->category->name ?? 'N/A' }}</div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Person</label>
                    <div class="mt-1 text-base text-gray-900">{{ $transaction->person->name ?? 'N/A' }}</div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Amount</label>
                    <div class="mt-1 text-lg font-bold text-green-600">
                        {{ $transaction->wallet->currency->symbol ?? '' }} {{ number_format($transaction->amount, 2) }}
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Wallet</label>
                    <div class="mt-1 text-base text-gray-900">{{ $transaction->wallet->name ?? 'N/A' }}</div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Date</label>
                    <div class="mt-1 text-base text-gray-900">{{ \Carbon\Carbon::parse($transaction->date)->format('d M, Y') }}</div>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700">Note</label>
                    <div class="mt-1 text-base text-gray-900">{{ $transaction->note ?? '-' }}</div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-2">
                <a href="{{ route('transactions.edit', $transaction->id) }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded hover:bg-indigo-700 transition">
                    Edit
                </a>
                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
