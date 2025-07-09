<x-app-layout>
    <x-slot name="title">
        {{ __('Wallet Management') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Wallet Management</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
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
                                        <span class="text-blue-100 font-medium">Wallets</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Stats and Create Button -->
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Total Wallets</p>
                                <p class="text-2xl font-bold text-white">{{ $wallets->total() }}</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <a href="{{ route('wallets.create') }}"
                               class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-white dark:bg-gray-100 text-blue-700 dark:text-blue-800 font-semibold rounded-xl hover:bg-blue-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="hidden sm:inline">Create Wallet</span>
                                <span class="sm:hidden">Create</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 p-4 sm:p-6">
                <form method="GET" class="space-y-4" id="filter-form" x-data="{ showAdvanced: false }">
                    <!-- Search Bar -->
                    <div class="relative max-w-2xl mx-auto">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search wallets by name, type, or currency..."
                               class="w-full pl-12 pr-12 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               autocomplete="off" />
                        
                        @php
                            $hasFilters = request('search') || request('filter') || request('wallet_type') || request('currency');
                        @endphp
                        
                        @if($hasFilters)
                            <a href="{{ route('wallets.index') }}"
                               class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    <!-- Filter Toggles -->
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <!-- Quick Filters -->
                        <div class="flex flex-wrap gap-2">
                            <button type="button" @click="document.querySelector('select[name=filter]').value='active'; document.querySelector('filter-form').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('filter') == 'active' ? 'bg-green-600 text-white border-green-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Active Wallets
                            </button>
                            <button type="button" @click="document.querySelector('select[name=filter]').value='inactive'; document.querySelector('filter-form').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('filter') == 'inactive' ? 'bg-red-600 text-white border-red-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Inactive Wallets
                            </button>
                        </div>

                        <!-- Advanced Filter Toggle -->
                        <button type="button" @click="showAdvanced = !showAdvanced"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                            Advanced Filters
                            <svg x-show="!showAdvanced" class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <svg x-show="showAdvanced" class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Advanced Filters Panel -->
                    <div x-show="showAdvanced" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <!-- Quick Filter Hidden Select -->
                        <select name="filter" class="hidden">
                            <option value="">All</option>
                            <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <!-- Wallet Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Wallet Type</label>
                            <select name="wallet_type"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Types</option>
                                @foreach ($walletTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('wallet_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Currency Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                            <select name="currency"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Currencies</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ request('currency') == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->code }} ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col items-end sm:flex-row gap-2 lg:col-span-2">
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                Apply Filters
                            </button>
                            <a href="{{ route('wallets.index') }}"
                               class="flex-1 px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-medium rounded-lg text-center transition-colors">
                                Reset
                            </a>
                        </div>
                    </div>

                    <!-- Search Summary -->
                    @if(request('search') || $hasFilters)
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @if(request('search'))
                                    Showing results for "<span class="font-semibold text-blue-600 dark:text-blue-400">{{ request('search') }}</span>"
                                    <span class="mx-2">•</span>
                                @endif
                                {{ $wallets->total() }} {{ Str::plural('wallet', $wallets->total()) }} found
                            </p>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Wallets Content -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Wallet</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Currency</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Balance</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($wallets as $wallet)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $loop->iteration + ($wallets->currentPage() - 1) * $wallets->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $wallet->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            {{ $wallet->walletType->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $wallet->currency->code }}</span>
                                            <span class="ml-2 text-gray-500 dark:text-gray-400">{{ $wallet->currency->symbol }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $wallet->balance >= 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                            {{ $wallet->currency->symbol }}{{ number_format($wallet->balance, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $wallet->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                            @if($wallet->is_active)
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Active
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                Inactive
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('wallets.show', $wallet->id) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 text-xs font-medium rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('wallets.edit', $wallet->id) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('Are you sure you want to delete this wallet? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 text-xs font-medium rounded-lg hover:bg-red-200 dark:hover:bg-red-800 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            @if(request('search') || $hasFilters)
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No wallets found</h3>
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">No wallets match your search criteria.</p>
                                                <a href="{{ route('wallets.index') }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                                    Clear Search
                                                </a>
                                            @else
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No wallets found</h3>
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first wallet.</p>
                                                <a href="{{ route('wallets.create') }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Create Wallet
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($wallets as $wallet)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $wallet->name }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $wallet->walletType->name }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                    #{{ $loop->iteration + ($wallets->currentPage() - 1) * $wallets->perPage() }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Balance</p>
                                    <p class="font-bold text-lg {{ $wallet->balance >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $wallet->currency->symbol }}{{ number_format($wallet->balance, 2) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Currency</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $wallet->currency->code }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $wallet->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                    {{ $wallet->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('wallets.show', $wallet->id) }}" 
                                       class="inline-flex items-center text-yellow-600 dark:text-yellow-400 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('wallets.edit', $wallet->id) }}" 
                                       class="inline-flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this wallet?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-red-600 dark:text-red-400 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                @if(request('search') || $hasFilters)
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No wallets found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">No wallets match your search criteria.</p>
                                    <a href="{{ route('wallets.index') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        Clear Search
                                    </a>
                                @else
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No wallets found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first wallet.</p>
                                    <a href="{{ route('wallets.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create Wallet
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Enhanced Pagination -->
            @if($transactions->hasPages())
                <div class="mt-6 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <x-pagination :paginator="$transactions" />
                </div>
            @endif
        </div>
    </div>
    
</x-app-layout>