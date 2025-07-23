<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Borrow / Lend') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-indigo-600 via-blue-700 to-blue-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Edit Borrow / Lend</h1>
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
                                        <span class="text-blue-100 font-medium">Edit</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="flex items-center">
                            @if($borrow->borrow_type === 'borrowed')
                                <div class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-red-800 dark:text-red-200 font-semibold">I Borrowed</span>
                                </div>
                            @else
                                <div class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-800 dark:text-green-200 font-semibold">I Lent</span>
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
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Borrow / Lend Details</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your borrow/lend information</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 lg:p-8">
                            <form action="{{ route('borrows.update', $borrow->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="space-y-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Type -->
                                        <div class="space-y-2">
                                            <label class="font-bold text-sm text-gray-900 dark:text-white">Type <span class="text-red-500">*</span></label>
                                            <select name="borrow_type" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" required>
                                                <option value="borrowed" {{ old('borrow_type', $borrow->borrow_type) === 'borrowed' ? 'selected' : '' }}>I Borrowed</option>
                                                <option value="lent" {{ old('borrow_type', $borrow->borrow_type) === 'lent' ? 'selected' : '' }}>I Lent</option>
                                            </select>
                                            @error('borrow_type')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Person -->
                                        <div class="space-y-2">
                                            <label class="font-bold text-sm text-gray-900 dark:text-white">Person <span class="text-red-500">*</span></label>
                                            <select name="person_id" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" required>
                                                <option value="">Select Person</option>
                                                @foreach ($people as $person)
                                                    <option value="{{ $person->id }}" {{ old('person_id', $borrow->person_id) == $person->id ? 'selected' : '' }}>{{ $person->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('person_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Wallet -->
                                        <div class="space-y-2">
                                            <label class="font-bold text-sm text-gray-900 dark:text-white">Wallet <span class="text-red-500">*</span></label>
                                            <select name="wallet_id" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" required>
                                                <option value="">Select Wallet</option>
                                                @foreach ($wallets as $wallet)
                                                    <option value="{{ $wallet->id }}" {{ old('wallet_id', $borrow->wallet_id) == $wallet->id ? 'selected' : '' }}>
                                                        {{ $wallet->name }} ({{ $wallet->currency->symbol }}{{ number_format($wallet->balance, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('wallet_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Amount -->
                                        <div class="space-y-2">
                                            <label class="font-bold text-sm text-gray-900 dark:text-white">Amount <span class="text-red-500">*</span></label>
                                            <input type="number" name="amount" min="0.01" step="0.01" required value="{{ old('amount', $borrow->amount) }}" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" placeholder="0.00">
                                            @error('amount')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Date -->
                                        <div class="space-y-2">
                                            <label class="font-bold text-sm text-gray-900 dark:text-white">Date <span class="text-red-500">*</span></label>
                                            <input type="date" name="date" required value="{{ old('date', $borrow->date ? \Carbon\Carbon::parse($borrow->date)->format('Y-m-d') : '') }}" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm">
                                            @error('date')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Note -->
                                        <div class="space-y-2">
                                            <label class="font-bold text-sm text-gray-900 dark:text-white">Note</label>
                                            <textarea name="note" rows="2" class="w-full px-4 py-3 border-2 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" placeholder="Optional notes">{{ old('note', $borrow->note) }}</textarea>
                                            @error('note')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-600 space-y-4 sm:space-y-0">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="text-red-500">*</span> Required fields
                                        </div>
                                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                            <a href="{{ route('borrows.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Cancel
                                            </a>
                                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 text-white font-bold rounded-xl transition-all duration-200 bg-gradient-to-r from-indigo-600 to-blue-700 hover:from-indigo-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Update Borrow/Lend
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
                                <p class="text-blue-800 dark:text-blue-200">You can update the type, person, wallet, amount, date, or notes for this borrow/lend.</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Partial and full repayments can be tracked from the details page.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('borrows.show', $borrow->id) }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                View Borrow/Lend
                            </a>
                            <a href="{{ route('borrows.create') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create New
                            </a>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Borrow/Lend Info
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">ID:</span>
                                <span class="font-medium text-gray-900 dark:text-white">#{{ $borrow->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Created:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $borrow->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Last Updated:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $borrow->updated_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Original Amount:</span>
                                <span class="font-medium {{ $borrow->borrow_type === 'lent' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $borrow->borrow_type === 'lent' ? '+' : '-' }}{{ $borrow->wallet->currency->symbol ?? '₹' }}{{ number_format($borrow->amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Optionally, you can add modals for adding Person/Wallet here, similar to your transaction page --}}

</x-app-layout>