<x-app-layout>
    <x-slot name="title">
        {{ __('EMI Loans') }} - {{ config('app.name', 'Expense Tracker') }}
    </x-slot>

    <div class="min-h-screen" x-data="{ showAdvanced: false }">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 dark:from-purple-800 dark:via-purple-900 dark:to-indigo-900 border-b border-purple-500 dark:border-purple-600 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">EMI Loan Management</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-purple-200 hover:text-white transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-purple-100 font-medium">EMI Loans</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        
                        <!-- Create Button -->
                        <a href="{{ route('emi-loans.create') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-100 text-purple-700 dark:text-purple-800 font-semibold rounded-xl hover:bg-purple-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="hidden sm:inline">Create EMI Loan</span>
                            <span class="sm:hidden">Create</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filters Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 p-6">
                <form method="GET" class="space-y-4" id="filter-form">
                    <!-- Search Bar -->
                    <div class="relative max-w-2xl mx-auto">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search loans by name, category, type..."
                               class="w-full pl-12 pr-12 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                               autocomplete="off" />
                        
                        @php
                            $hasFilters = request('search') || request('status') || request('loan_type') || request('category');
                        @endphp
                        
                        @if($hasFilters)
                            <a href="{{ route('emi-loans.index') }}"
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
                            <button type="button" @click="document.querySelector('select[name=status]').value='active'; document.querySelector('#filter-form').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('status') == 'active' ? 'bg-green-600 text-white border-green-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Active
                            </button>
                            <button type="button" @click="document.querySelector('select[name=status]').value='closed'; document.querySelector('#filter-form').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('status') == 'closed' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Closed
                            </button>
                            <button type="button" @click="document.querySelector('select[name=loan_type]').value='fixed'; document.querySelector('#filter-form').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('loan_type') == 'fixed' ? 'bg-purple-600 text-white border-purple-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Fixed
                            </button>
                            <button type="button" @click="document.querySelector('select[name=loan_type]').value='reducing_balance'; document.querySelector('#filter-form').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('loan_type') == 'reducing_balance' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Reducing Balance
                            </button>
                        </div>

                        <!-- Advanced Filters Toggle -->
                        <button type="button" @click="showAdvanced = !showAdvanced"
                                class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2 transition-transform" :class="{ 'rotate-180': showAdvanced }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            Advanced Filters
                        </button>
                    </div>

                    <!-- Advanced Filters Panel -->
                    <div x-show="showAdvanced" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Loan Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Loan Type</label>
                            <select name="loan_type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">All Types</option>
                                <option value="fixed" {{ request('loan_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="reducing_balance" {{ request('loan_type') == 'reducing_balance' ? 'selected' : '' }}>Reducing Balance</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                            <select name="sort_by" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                                <option value="start_date" {{ request('sort_by') == 'start_date' ? 'selected' : '' }}>Start Date</option>
                                <option value="total_amount" {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Total Amount</option>
                                <option value="monthly_emi" {{ request('sort_by') == 'monthly_emi' ? 'selected' : '' }}>Monthly EMI</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </div>

                        <!-- Order -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order</label>
                            <select name="order" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Apply Filters Button -->
                    <div x-show="showAdvanced" x-transition class="flex justify-center pt-4">
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics Cards -->
            @if($emiLoans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total Active Loans -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Loans</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $emiLoans->where('status', 'active')->count() }}</p>
                            </div>
                            <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Loan Amount -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Amount</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($emiLoans->sum('total_amount'), 2) }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly EMI -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly EMI</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($emiLoans->where('status', 'active')->sum('monthly_emi'), 2) }}</p>
                            </div>
                            <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Closed Loans -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Closed Loans</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $emiLoans->where('status', 'closed')->count() }}</p>
                            </div>
                            <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- EMI Loans Table -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                @if($emiLoans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Loan Details
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Amount & EMI
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Terms
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($emiLoans as $loan)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $loan->name }}
                                                    </div>
                                                    @if($loan->category)
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $loan->category->name }}
                                                        </div>
                                                    @endif
                                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                                        {{ $loan->loan_type === 'fixed' ? 'Fixed Rate' : 'Reducing Balance' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                ₹{{ number_format($loan->total_amount, 2) }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                EMI: ₹{{ number_format($loan->monthly_emi, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                                {{ $loan->interest_rate }}% interest
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $loan->tenure_months }} months
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Start: {{ $loan->start_date->format('M d, Y') }}
                                            </div>
                                            @if($loan->is_auto_deduct)
                                                <div class="inline-flex items-center text-xs text-green-600 dark:text-green-400 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Auto Deduct
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($loan->status === 'active')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></div>
                                                    Active
                                                </span>
                                            @elseif($loan->status === 'closed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                    <div class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></div>
                                                    Closed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                    <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></div>
                                                    Cancelled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <!-- View Button -->
                                                <a href="{{ route('emi-loans.show', $loan) }}"
                                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors duration-200"
                                                   title="View Details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                <!-- Edit Button -->
                                                @if($loan->status !== 'closed')
                                                    <a href="{{ route('emi-loans.edit', $loan) }}"
                                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors duration-200"
                                                       title="Edit Loan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                @endif

                                                <!-- Delete Button -->
                                                <form method="POST" action="{{ route('emi-loans.destroy', $loan) }}" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to delete this loan?')"
                                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors duration-200"
                                                            title="Delete Loan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full mb-4">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No EMI loans found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Start by creating your first EMI loan to track your loan payments.</p>
                        <a href="{{ route('emi-loans.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create EMI Loan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
