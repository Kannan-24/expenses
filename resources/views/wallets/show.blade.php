<x-app-layout>
    <x-slot name="title">
        {{ __('Wallet Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class=" bg-white p-6 rounded-2xl shadow flex flex-col"
        style="height: 93vh; overflow: auto;">
        <!-- Breadcrumb -->
        <div class="flex justify-between items-center mb-4">
            <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('wallets.index') }}" class="inline-flex items-center hover:text-blue-600">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            Wallets
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                        </svg>
                        <span class="text-gray-700">Wallet Details</span>
                    </li>
                </ol>
            </nav>

        </div>

        <hr class="p-2 border-t border-gray-400">

        <!-- Wallet Details -->
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Wallet Details :</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('wallets.edit', $wallet->id) }}"
                        class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded hover:bg-indigo-700 transition">
                        Edit
                    </a>
                    <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div class="flex items-center gap-4">
                    <span class="w-16 text-sm font-bold text-gray-900">Name</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">{{ $wallet->name }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-16 text-sm font-bold text-gray-900">Type</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">{{ $wallet->walletType?->name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-16 text-sm font-bold text-gray-900">Balance</span>
                    <span class="mx-1">:</span>
                    <span class="text-lg font-bold text-green-600">
                        {{ number_format($wallet->balance, 2) }}
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-16 text-sm font-bold text-gray-900">Currency</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">{{ $wallet->currency?->code ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-16 text-sm font-bold text-gray-900">Active</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">
                        @if ($wallet->is_active)
                            <span class="text-green-600 font-semibold">Yes</span>
                        @else
                            <span class="text-red-600 font-semibold">No</span>
                        @endif
                    </span>
                </div>
            </div>

            <hr class="my-2 border-t border-gray-400">

            <!-- Transaction History -->
            <div>
                <h3 class="text-md font-semibold text-gray-800 mb-2">Transaction History</h3>
                <div class="overflow-auto flex-1">
                    <table class="w-full text-sm text-left text-gray-700 bg-white">
                        <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Category</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2">{{ $transaction->category->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        @if ($transaction->type === 'income')
                                            <span class="text-green-600 font-semibold">Income</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Transaction</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="{{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            ₹{{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="text-yellow-600 hover:underline">Show</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-400">No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $transactions->links() }}
                </div>
            </div>


        </div>
    </div>
    
</x-app-layout>
