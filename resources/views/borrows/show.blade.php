<x-app-layout>
    <x-slot name="title">
        {{ __('Borrow Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto">

            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Borrow Details</h1>
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
                                        <a href="{{ route('borrows.index') }}" class="text-blue-200 hover:text-white transition-colors">
                                            Borrows
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">Details</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="flex items-center">
                            @if($borrow->status === 'returned')
                                <div class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-800 dark:text-green-200 font-semibold">Fully Returned</span>
                                </div>
                            @elseif($borrow->status === 'partial')
                                <div class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                                        <path stroke="currentColor" stroke-width="2" d="M7 10h6M10 7v6" />
                                    </svg>
                                    <span class="text-yellow-800 dark:text-yellow-200 font-semibold">Partially Returned</span>
                                </div>
                            @else
                                <div class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-red-800 dark:text-red-200 font-semibold">Not Returned</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Borrow Details Card -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-600 p-4 sm:p-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Borrow Information</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete details of this borrow/lend entry</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6">
                        <div class="space-y-6">
                            <div class="text-center p-6 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-600 mb-6">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Borrowed/Lent Amount</p>
                                <p class="text-4xl font-bold {{ $borrow->borrow_type === 'lent' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->amount, 2) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    {{ ucfirst($borrow->borrow_type) }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Person
                                    </label>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $borrow->person->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Wallet
                                    </label>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $borrow->wallet->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Date
                                    </label>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ \Carbon\Carbon::parse($borrow->date)->format('l, F j, Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Returned
                                    </label>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->returned_amount, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Remaining
                                    </label>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->amount - $borrow->returned_amount, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Notes
                                    </label>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white">
                                            {{ $borrow->note ?: 'No notes.' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions and Summary -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('borrows.edit', $borrow->id) }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Borrow
                            </a>
                            <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this borrow? This action cannot be undone and will also remove all associated return histories.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Borrow
                                </button>
                            </form>
                            <a href="{{ route('borrows.index') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Back to Borrows
                            </a>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"></path>
                            </svg>
                            Borrow Summary
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Borrow ID</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400 font-mono">#{{ $borrow->id }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Return Records</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $borrow->histories->count() }} total</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Created</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $borrow->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            @if($borrow->updated_at != $borrow->created_at)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $borrow->updated_at->format('M d, Y') }}
                                    </span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Remaining Amount</span>
                                <span class="text-sm text-gray-900 dark:text-white font-bold">
                                    {{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->amount - $borrow->returned_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrow Return History Section -->
            <div class="mt-6 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
                 x-data="{ openReturnModal: false, openEditModal: null }" x-cloak>
                <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-600 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Return History</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Track all repayments/returns for this borrow</p>
                            </div>
                        </div>
                        @if($borrow->status !== 'returned')
                            <button
                                type="button"
                                @click="openReturnModal = true"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl shadow transition-all"
                            >
                                Add Return
                            </button>
                        @endif
                    </div>
                </div>
                <!-- Modal for Add Return -->
                @if($borrow->status !== 'returned')
                <div
                    x-show="openReturnModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                    style="display: none;"
                >
                    <div @click.away="openReturnModal = false" class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 w-full max-w-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Record Repayment / Return</h3>
                            <button @click="openReturnModal = false" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                        </div>
                        <form action="{{ route('borrows.repay', $borrow->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="font-bold text-sm text-gray-900 dark:text-white">Amount Returned</label>
                                    <input type="number" name="repay_amount" min="0.01" max="{{ $borrow->amount - $borrow->returned_amount }}" step="0.01" required class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" placeholder="Amount">
                                </div>
                                <div>
                                    <label class="font-bold text-sm text-gray-900 dark:text-white">Wallet</label>
                                    <select name="wallet_id" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" required>
                                        @foreach ($wallets as $wallet)
                                            <option value="{{ $wallet->id }}">{{ $wallet->name }} ({{ $wallet->currency->symbol }}{{ number_format($wallet->balance, 2) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="font-bold text-sm text-gray-900 dark:text-white">Date</label>
                                    <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="button" @click="openReturnModal = false" class="px-4 py-2 text-gray-900 dark:text-white bg-gray-200 dark:bg-gray-700 rounded-xl mr-2">Cancel</button>
                                <button type="submit" class="px-8 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl">Record Return</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Modal for Edit Return -->
                @foreach ($borrow->histories as $history)
                <div
                    x-show="openEditModal === {{ $history->id }}"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                    style="display: none;"
                >
                    <div @click.away="openEditModal = null" class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 w-full max-w-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Return Entry</h3>
                            <button @click="openEditModal = null" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                        </div>
                        <form action="{{ route('borrows.return.update', [$borrow->id, $history->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="font-bold text-sm text-gray-900 dark:text-white">Amount Returned</label>
                                    <input type="number" name="amount" min="0.01" max="{{ $borrow->amount - $borrow->histories->where('id', '!=', $history->id)->sum('amount') }}" step="0.01" required value="{{ $history->amount }}" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" placeholder="Amount">
                                </div>
                                <div>
                                    <label class="font-bold text-sm text-gray-900 dark:text-white">Wallet</label>
                                    <select name="wallet_id" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" required>
                                        @foreach ($wallets as $wallet)
                                            <option value="{{ $wallet->id }}" {{ $history->wallet_id == $wallet->id ? 'selected' : '' }}>
                                                {{ $wallet->name }} ({{ $wallet->currency->symbol }}{{ number_format($wallet->balance, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="font-bold text-sm text-gray-900 dark:text-white">Date</label>
                                    <input type="date" name="date" required value="{{ $history->date }}" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="button" @click="openEditModal = null" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-xl mr-2">Cancel</button>
                                <button type="submit" class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl">Update Return</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach

                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Wallet</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($borrow->histories as $history)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($history->date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $history->wallet->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($history->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button @click="openEditModal = {{ $history->id }}" class="text-blue-600 hover:underline text-xs font-semibold">Edit</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No return history found</h3>
                                            <p class="text-gray-500 dark:text-gray-400">No repayments/returns have been recorded for this borrow.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($borrow->histories as $history)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex flex-col gap-2">
                            <div class="flex items-center justify-between mb-1">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Return #{{ $loop->iteration }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($history->date)->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="font-bold text-green-600 dark:text-green-400">
                                    +{{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($history->amount, 2) }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">Wallet:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $history->wallet->name ?? '-' }}</span>
                            </div>
                            <div class="mt-2">
                                <button @click="openEditModal = {{ $history->id }}" class="text-blue-600 hover:underline text-xs font-semibold">Edit</button>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No return history found</h3>
                                <p class="text-gray-500 dark:text-gray-400">No repayments/returns have been recorded for this borrow.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>