<x-app-layout>
    <x-slot name="title">
        {{ __('Add Borrow / Lend') }} - {{ config('app.name', 'Cazhoo') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Add Borrow / Lend</h1>
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
                                        <span class="text-blue-100 font-medium">Add Borrow / Lend</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-blue-200">People</p>
                                <p class="text-2xl font-bold text-white">{{ $people->count() }}</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Today</p>
                                <p class="text-lg font-semibold text-white">{{ now()->format('M d') }}</p>
                            </div>
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
            @else
                <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-2xl p-6 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200">No Wallets Available</h3>
                            <p class="text-yellow-700 dark:text-yellow-300">You need to create a wallet before adding borrows/lends.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Form Section -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-600 p-4 sm:p-6">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Borrow / Lend Details</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Enter borrow/lend information</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 lg:p-8">
                            <form action="{{ route('borrows.store') }}" method="POST">
                                @csrf
                                <div class="space-y-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Type -->
                                        <div class="space-y-2">
                                            <label class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Type <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <select name="borrow_type" required
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm">
                                                <option value="borrowed" {{ old('borrow_type') === 'borrowed' ? 'selected' : '' }}>I Borrowed</option>
                                                <option value="lent" {{ old('borrow_type') === 'lent' ? 'selected' : '' }}>I Lent</option>
                                            </select>
                                            @error('borrow_type')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Person -->
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <label class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                    Person <span class="text-red-500 ml-1">*</span>
                                                </label>
                                                <button type="button" onclick="openPersonModal()"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-full hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Add New
                                                </button>
                                            </div>
                                            <select name="person_id" id="person_id" required
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm">
                                                <option value="">Select Person</option>
                                                @foreach ($people as $person)
                                                    <option value="{{ $person->id }}" {{ old('person_id') == $person->id ? 'selected' : '' }}>{{ $person->name }}</option>
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
                                            <div class="flex items-center justify-between">
                                                <label class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                    Wallet <span class="text-red-500 ml-1">*</span>
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
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm">
                                                <option value="">Select Wallet</option>
                                                @foreach ($wallets as $wallet)
                                                    <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
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
                                            <label class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Amount <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="number" name="amount" min="0.01" step="0.01" required value="{{ old('amount') }}"
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm" placeholder="0.00">
                                            @error('amount')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Date -->
                                        <div class="space-y-2">
                                            <label class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Date <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="date" name="date" required value="{{ old('date', date('Y-m-d')) }}"
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm">
                                            @error('date')
                                                <p class="text-sm text-red-700 dark:text-red-400 mt-2 font-semibold">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Note -->
                                        <div class="space-y-2">
                                            <label class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Note <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">(Optional)</span>
                                            </label>
                                            <textarea name="note" rows="2"
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-medium shadow-sm resize-none placeholder-gray-500 dark:placeholder-gray-400"
                                                placeholder="Optional notes">{{ old('note') }}</textarea>
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
                                            <a href="{{ route('borrows.index') }}"
                                               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Cancel
                                            </a>
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Add Borrow/Lend
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
                            Quick Tips
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Choose <b>I Borrowed</b> if you took money, <b>I Lent</b> if you gave money.</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">You can record repayments from the borrow details page.</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Track outstanding and returned amounts easily.</p>
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
                            <a href="{{ route('borrows.index') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View All Borrows
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

    <!-- Person Modal -->
    <div id="personModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6">
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
                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6">
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Wallet Name</label>
                    <input type="text" id="newWalletName"
                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                           placeholder="Enter wallet name" required>
                </div>
                @if (isset($currencies) && $currencies->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                        <select id="newWalletCurrency"
                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->symbol }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Initial Balance</label>
                    <input type="number" id="newWalletBalance" value="0"
                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                    const select = document.getElementById('person_id');
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
            const name = document.getElementById('newWalletName').value.trim();
            const currency = document.getElementById('newWalletCurrency').value;
            const balance = document.getElementById('newWalletBalance').value || 0;
            if (!name || !currency) {
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
                    name,
                    currency_id: currency,
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
        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const personModal = document.getElementById('personModal');
            const walletModal = document.getElementById('walletModal');
            if (event.target === personModal) closePersonModal();
            if (event.target === walletModal) closeWalletModal();
        });
        // Close modals with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePersonModal();
                closeWalletModal();
            }
        });
        // Auto-focus amount field after selecting wallet
        document.getElementById('wallet_id').addEventListener('change', function() {
            if (this.value) {
                document.querySelector('input[name="amount"]').focus();
            }
        });
    </script>
</x-app-layout>