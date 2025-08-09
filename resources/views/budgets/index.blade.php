<x-app-layout>
    <x-slot name="title">
        {{ __('Budget Management') }} - {{ config('app.name', 'Cazhoo') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Budget Management</h1>
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
                                        <span class="text-blue-100 font-medium">Budgets</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Stats and Create Button -->
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Total Budgets</p>
                                <p class="text-2xl font-bold text-white">{{ $budgets->total() }}</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Current Date</p>
                                <p class="text-lg font-bold text-white">Jul 07, 2025</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <a href="{{ route('budgets.create') }}"
                               class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-white dark:bg-gray-100 text-indigo-700 dark:text-indigo-800 font-semibold rounded-xl hover:bg-blue-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="hidden sm:inline">Create Budget</span>
                                <span class="sm:hidden">Create</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 p-4 sm:p-6" x-data="{ showAdvanced: false }">
                <form method="GET" class="space-y-4" id="form-filter">
                    <!-- Search Bar -->
                    <div class="relative max-w-2xl mx-auto">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search budgets by category, amount, or date range..."
                               class="w-full pl-12 pr-12 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               autocomplete="off" />
                        
                        @php
                            $hasFilters = request('search') || request('filter') || request('start_date') || request('end_date') || request('category') || request('frequency') || request('roll_over');
                        @endphp
                        
                        @if($hasFilters)
                            <a href="{{ route('budgets.index') }}"
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
                            <button type="button" @click="document.querySelector('select[name=filter]').value='active'; document.querySelector('form-filter').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('filter') == 'active' ? 'bg-green-600 text-white border-green-600' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Active Budgets
                            </button>
                            <button type="button" @click="document.querySelector('select[name=filter]').value='expired'; document.querySelector('form-filter').submit();"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border {{ request('filter') == 'expired' ? 'bg-red-600 text-white border-red-600' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600' }} transition-colors">
                                Expired Budgets
                            </button>
                        </div>

                        <!-- Advanced Filter Toggle -->
                        <button type="button" @click="showAdvanced = !showAdvanced"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 12L5 4" stroke="currentColor" stroke-linecap="round"></path> 
                                    <path d="M19 20L19 17" stroke="currentColor" stroke-linecap="round"></path> 
                                    <path d="M5 20L5 16" stroke="currentColor" stroke-linecap="round"></path> 
                                    <path d="M19 13L19 4" stroke="currentColor" stroke-linecap="round"></path> 
                                    <path d="M12 7L12 4" stroke="currentColor" stroke-linecap="round"></path> 
                                    <path d="M12 20L12 11" stroke="currentColor" stroke-linecap="round"></path> 
                                    <circle cx="5" cy="14" r="2" stroke="currentColor" stroke-linecap="round"></circle> 
                                    <circle cx="12" cy="9" r="2" stroke="currentColor" stroke-linecap="round"></circle> 
                                    <circle cx="19" cy="15" r="2" stroke="currentColor" stroke-linecap="round"></circle> 
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
                    <div x-show="showAdvanced" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <!-- Quick Filter Hidden Select -->
                        <select name="filter" class="hidden">
                            <option value="">All</option>
                            <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ request('filter') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>

                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                   class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                   class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select name="category"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Frequency Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Frequency</label>
                            <select name="frequency"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Frequencies</option>
                                <option value="monthly" {{ request('frequency') == 'monthly' ? 'selected' : '' }}>📅 Monthly</option>
                                <option value="weekly" {{ request('frequency') == 'weekly' ? 'selected' : '' }}>🗓️ Weekly</option>
                                <option value="yearly" {{ request('frequency') == 'yearly' ? 'selected' : '' }}>📆 Yearly</option>
                            </select>
                        </div>

                        <!-- Roll Over Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Roll Over</label>
                            <select name="roll_over"
                                    class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All</option>
                                <option value="1" {{ request('roll_over') === '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ request('roll_over') === '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col items-end sm:flex-row gap-2">
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                Apply Filters
                            </button>
                            <a href="{{ route('budgets.index') }}"
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
                                {{ $budgets->total() }} {{ Str::plural('budget', $budgets->total()) }} found
                            </p>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Budgets Content -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Budget</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($budgets as $budget)
                                @php
                                    $isActive = \Carbon\Carbon::now()->between($budget->start_date, $budget->end_date);
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $loop->iteration + ($budgets->currentPage() - 1) * $budgets->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Budget #{{ $budget->id }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ ucfirst($budget->frequency ?? 'monthly') }} budget
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                            {{ $budget->category->name ?? 'No Category' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="font-bold text-lg text-blue-600 dark:text-blue-400">
                                            ₹{{ number_format($budget->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <div>
                                            <div class="font-medium">{{ \Carbon\Carbon::parse($budget->start_date)->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">to {{ \Carbon\Carbon::parse($budget->end_date)->format('M d, Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isActive ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                            @if($isActive)
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Active
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                Expired
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('budgets.show', $budget->id) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 text-xs font-medium rounded-lg hover:bg-yellow-200 dark:hover:bg-yellow-800 transition-colors">
                                               <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('budgets.edit', $budget->id) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 text-xs font-medium rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('Are you sure you want to delete this budget? This action cannot be undone.')">
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            @if(request('search') || $hasFilters)
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No budgets found</h3>
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">No budgets match your search criteria.</p>
                                                <a href="{{ route('budgets.index') }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                                    Clear Search
                                                </a>
                                            @else
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No budgets found</h3>
                                                <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first budget.</p>
                                                <a href="{{ route('budgets.create') }}"
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Create Budget
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
                    @forelse ($budgets as $budget)
                        @php
                            $isActive = \Carbon\Carbon::now()->between($budget->start_date, $budget->end_date);
                        @endphp
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $budget->category->name ?? 'No Category' }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Budget #{{ $budget->id }} • {{ ucfirst($budget->frequency ?? 'monthly') }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isActive ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                    #{{ $loop->iteration + ($budgets->currentPage() - 1) * $budgets->perPage() }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Budget Amount</p>
                                    <p class="font-bold text-xl text-blue-600 dark:text-blue-400">₹{{ number_format($budget->amount, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Period</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($budget->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($budget->end_date)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isActive ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                    {{ $isActive ? 'Active' : 'Expired' }}
                                </span>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('budgets.show', $budget->id) }}" 
                                       class="inline-flex items-center text-yellow-600 dark:text-yellow-400 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                        View
                                    </a>
                                    <a href="{{ route('budgets.edit', $budget->id) }}" 
                                       class="inline-flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this budget?')">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                @if(request('search') || $hasFilters)
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No budgets found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">No budgets match your search criteria.</p>
                                    <a href="{{ route('budgets.index') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        Clear Search
                                    </a>
                                @else
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No budgets found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first budget.</p>
                                    <a href="{{ route('budgets.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create Budget
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Enhanced Pagination -->
            @if($budgets->hasPages())
                <div class="mt-6 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $budgets->firstItem() }} to {{ $budgets->lastItem() }} of {{ $budgets->total() }} budgets
                        </div>
                        <div>
                            <x-pagination :paginator="$budgets" />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
</x-app-layout>