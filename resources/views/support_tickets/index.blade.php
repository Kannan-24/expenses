<x-app-layout>
    <x-slot name="title">
        {{ __('Support Center') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class=" space-y-6">

         <!-- Enhanced Breadcrumb -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
            <nav class="flex text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                        </svg>
                        <span class="text-gray-900 dark:text-white font-medium">Support</span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Enhanced Header Section -->
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-900 dark:via-blue-950 dark:to-indigo-900 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10 dark:opacity-30"></div>
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="p-2 bg-white bg-opacity-20 dark:bg-white/10 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-bold">Support Center</h1>
                        </div>
                        <p class="text-blue-100 dark:text-blue-200 text-lg">Get help and manage your support tickets</p>
                    </div>
                    
                    <!-- Create Ticket Button -->
                    <div class="mt-4 lg:mt-0">
                        <a href="{{ route('support_tickets.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-900 text-blue-700 dark:text-blue-300 font-semibold rounded-xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create New Ticket
                        </a>
                    </div>
                </div>
            </div>
        </div>

       
        <!-- Enhanced Statistics Cards with Dark Mode -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-green-500 dark:border-green-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Open Tickets</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $supportTickets->where('status', 'opened')->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-blue-500 dark:border-blue-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Admin Replied</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $supportTickets->where('status', 'admin_replied')->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 dark:border-yellow-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Awaiting Response</p>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $supportTickets->where('status', 'customer_replied')->count() }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-red-500 dark:border-red-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Closed Tickets</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $supportTickets->where('status', 'closed')->count() }}</p>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>


        <!-- Enhanced Search and Filters (Dark Mode Ready) -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 p-6">
            <form method="GET" action="{{ route('support_tickets.index') }}" class="space-y-4" id="filterForm">
                <!-- Main Search Bar -->
                <div class="flex items-center bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">
                    <!-- Search Icon (Left) -->
                    <div class="pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </div>
                    <!-- Search Input -->
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search tickets by subject, ID, or description..."
                        class="flex-1 px-4 py-4 border-0 bg-transparent focus:ring-0 focus:outline-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-lg rounded-xl"
                        onkeyup="debounceSearch(this)">
                    @php $hasFilters = request('search') || request('filter') || request('start_date') || request('end_date') || request('status') || request('priority'); @endphp

                    <!-- Clear Search Button (Right) -->
                    @if($hasFilters)
                        <div class="pr-4 flex items-center">
                            <a href="{{ route('support_tickets.index') }}" 
                            class="text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-400 transition-colors p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800" 
                            title="Clear all filters">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
                <!-- Filter Controls -->
                <div class="space-y-4" x-data="{ showAdvanced: false }">
                    <!-- Quick Filters Section -->
                    <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex flex-col space-y-4">
                            <!-- Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Quick Filters
                                </h3>
                                <!-- Advanced Filters Toggle -->
                                <button type="button" @click="showAdvanced = !showAdvanced"
                                    class="inline-flex items-center px-3 py-2 text-xs sm:text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors duration-200 border border-blue-200 dark:border-blue-800">
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
                                    <span class="hidden sm:inline">Advanced Filters</span>
                                    <span class="sm:hidden">Advanced</span>
                                    <svg class="w-4 h-4 ml-1.5 transition-transform duration-200" 
                                        :class="showAdvanced ? 'rotate-180' : ''" 
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Quick Filters -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
                                <!-- Time Period Filter -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Time Period</label>
                                    <select name="filter" 
                                            onchange="submitFilterForm()"
                                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="">All Time</option>
                                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                                        <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>Last Month</option>
                                        <option value="3months" {{ request('filter') == '3months' ? 'selected' : '' }}>Last 3 Months</option>
                                        <option value="6months" {{ request('filter') == '6months' ? 'selected' : '' }}>Last 6 Months</option>
                                    </select>
                                </div>
                                <!-- Status Filter -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select name="status" 
                                            onchange="submitFilterForm()"
                                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="">All Statuses</option>
                                        <option value="opened" {{ request('status') == 'opened' ? 'selected' : '' }}>Open</option>
                                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                        <option value="admin_replied" {{ request('status') == 'admin_replied' ? 'selected' : '' }}>Admin Replied</option>
                                        <option value="customer_replied" {{ request('status') == 'customer_replied' ? 'selected' : '' }}>Customer Replied</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                                <!-- Priority Filter -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Priority</label>
                                    <select name="priority" 
                                            onchange="submitFilterForm()"
                                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="">All Priorities</option>
                                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                </div>
                                <!-- Quick Actions -->
                                <div class="space-y-1.5 flex flex-col justify-end">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('support_tickets.index') }}" 
                                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-2.5 text-xs font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 border border-gray-300 dark:border-gray-700">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            <span class="hidden sm:inline">Reset</span>
                                            <span class="sm:hidden">Reset</span>
                                        </a>
                                        <button type="button" onclick="exportData()" 
                                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-2.5 text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors duration-200 border border-green-200 dark:border-green-800">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="hidden sm:inline">Export</span>
                                            <span class="sm:hidden">Export</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Advanced Filters Panel -->
                    <div x-show="showAdvanced" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                        <div class="space-y-4">
                            <!-- Advanced Filters Header -->
                            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                    </svg>
                                    Advanced Search Options
                                </h4>
                                <span class="text-xs text-gray-500 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-full">
                                    More precise filtering
                                </span>
                            </div>
                            <!-- Advanced Filter Fields -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                <!-- Date Range -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="date" 
                                        name="start_date" 
                                        value="{{ request('start_date') }}"
                                        max="2025-07-03"
                                        onchange="submitFilterForm()"
                                        class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="date" 
                                        name="end_date" 
                                        value="{{ request('end_date') }}"
                                        max="2025-07-03"
                                        onchange="submitFilterForm()"
                                        class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                </div>
                                <!-- User Filter (Admin Only) -->
                                @if (Auth::user()->hasRole('admin'))
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">User</label>
                                        <select name="user" 
                                                onchange="submitFilterForm()"
                                                class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                            <option value="">All Users</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <!-- Category Filter -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Category</label>
                                    <select name="category" 
                                            onchange="submitFilterForm()"
                                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="">All Categories</option>
                                        <option value="technical" {{ request('category') == 'technical' ? 'selected' : '' }}>Technical Support</option>
                                        <option value="billing" {{ request('category') == 'billing' ? 'selected' : '' }}>Billing & Payments</option>
                                        <option value="feature" {{ request('category') == 'feature' ? 'selected' : '' }}>Feature Request</option>
                                        <option value="bug" {{ request('category') == 'bug' ? 'selected' : '' }}>Bug Report</option>
                                        <option value="account" {{ request('category') == 'account' ? 'selected' : '' }}>Account Issues</option>
                                        <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <!-- Sort Options -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Sort By</label>
                                    <select name="sort" 
                                            onchange="submitFilterForm()"
                                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="created_at_desc" {{ request('sort', 'created_at_desc') == 'created_at_desc' ? 'selected' : '' }}>Newest First</option>
                                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest First</option>
                                        <option value="updated_at_desc" {{ request('sort') == 'updated_at_desc' ? 'selected' : '' }}>Recently Updated</option>
                                        <option value="priority_desc" {{ request('sort') == 'priority_desc' ? 'selected' : '' }}>High Priority First</option>
                                        <option value="subject_asc" {{ request('sort') == 'subject_asc' ? 'selected' : '' }}>Subject A-Z</option>
                                    </select>
                                </div>
                                <!-- Items Per Page -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300">Items Per Page</label>
                                    <select name="per_page" 
                                            onchange="submitFilterForm()"
                                            class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 border-t border-gray-100 dark:border-gray-800 space-y-3 sm:space-y-0">
                                <!-- Filter Info -->
                                <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Use multiple filters for more precise results</span>
                                </div>
                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                    <a href="{{ route('support_tickets.index') }}" 
                                    class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200 border border-gray-300 dark:border-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Reset All Filters
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Apply Advanced Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['filter', 'status', 'priority', 'start_date', 'end_date', 'user', 'category', 'search', 'sort']))
                        <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800 p-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Active Filters:</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if(request('filter'))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200">
                                            Period: {{ ucfirst(str_replace(['days', 'month'], [' Days', ' Month'], request('filter'))) }}
                                        </span>
                                    @endif
                                    @if(request('status'))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200">
                                            Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                                        </span>
                                    @endif
                                    @if(request('priority'))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-800 text-orange-800 dark:text-orange-200">
                                            Priority: {{ ucfirst(request('priority')) }}
                                        </span>
                                    @endif
                                    @if(request('category'))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-800 text-purple-800 dark:text-purple-200">
                                            Category: {{ ucfirst(request('category')) }}
                                        </span>
                                    @endif
                                    @if(request('search'))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-800 text-indigo-800 dark:text-indigo-200">
                                            Search: "{{ Str::limit(request('search'), 20) }}"
                                        </span>
                                    @endif
                                    @if(request('start_date') || request('end_date'))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200">
                                            Date Range: {{ request('start_date') ?: 'Any' }} to {{ request('end_date') ?: 'Today' }}
                                        </span>
                                    @endif
                                    <a href="{{ route('support_tickets.index') }}" 
                                    class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Clear All
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Show Deleted Toggle -->
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" 
                            name="show_deleted" 
                            value="1"
                            {{ request('show_deleted') ? 'checked' : '' }} 
                            onchange="submitFilterForm()"
                            class="sr-only">
                        <div class="relative">
                            <div class="block bg-gray-300 dark:bg-gray-600 w-14 h-8 rounded-full transition-colors group-hover:bg-gray-400 dark:group-hover:bg-gray-500"></div>
                            <div class="dot absolute left-1 top-1 bg-white dark:bg-gray-900 w-6 h-6 rounded-full transition-transform {{ request('show_deleted') ? 'transform translate-x-6' : '' }}"></div>
                            <div class="dot-inner absolute left-1 top-1 w-6 h-6 rounded-full transition-colors {{ request('show_deleted') ? 'bg-blue-600 dark:bg-blue-400 transform translate-x-6' : 'bg-white dark:bg-gray-900' }}"></div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-gray-900 dark:group-hover:text-white">
                            Show Deleted Tickets
                            @if(request('show_deleted'))
                                <span class="text-xs text-blue-600 dark:text-blue-400">(Active)</span>
                            @endif
                        </span>
                    </label>
                </div>
            </form>
        </div>

        <!-- Enhanced JavaScript for Better UX -->
        <script>
            let searchTimeout;
            
            // Debounced search function
            function debounceSearch(input) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    if (input.value.length >= 3 || input.value.length === 0) {
                        submitFilterForm();
                    }
                }, 500); // Wait 500ms after user stops typing
            }

            // Submit filter form function
            function submitFilterForm() {
                const form = document.getElementById('filterForm');
                if (form) {
                    // Show loading state
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML = `
                            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Applying Filters...
                        `;
                        submitButton.disabled = true;
                    }
                    
                    form.submit();
                }
            }

            // Export functionality
            function exportData() {
                const params = new URLSearchParams(window.location.search);
                params.set('export', 'csv');
                
                const exportUrl = `{{ route('support_tickets.index') }}?${params.toString()}`;
                
                // Show loading state
                const exportBtn = event.target.closest('button');
                const originalContent = exportBtn.innerHTML;
                exportBtn.innerHTML = `
                    <svg class="w-3 h-3 mr-1.5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="hidden sm:inline">Exporting...</span>
                    <span class="sm:hidden">...</span>
                `;
                exportBtn.disabled = true;
                
                // Create temporary link for download
                const link = document.createElement('a');
                link.href = exportUrl;
                link.download = `support-tickets-${new Date().toISOString().split('T')[0]}.csv`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Restore button after delay
                setTimeout(() => {
                    exportBtn.innerHTML = originalContent;
                    exportBtn.disabled = false;
                }, 2000);
                
                // Show success notification
                showNotification('Export started! Download will begin shortly.', 'success');
            }

            // Date validation
            document.addEventListener('DOMContentLoaded', function() {
                const startDateInput = document.querySelector('input[name="start_date"]');
                const endDateInput = document.querySelector('input[name="end_date"]');
                
                if (startDateInput && endDateInput) {
                    startDateInput.addEventListener('change', function() {
                        if (this.value) {
                            endDateInput.min = this.value;
                        }
                    });
                    
                    endDateInput.addEventListener('change', function() {
                        if (this.value) {
                            startDateInput.max = this.value;
                        }
                    });
                }
                
                // Initialize date constraints
                if (startDateInput && startDateInput.value && endDateInput) {
                    endDateInput.min = startDateInput.value;
                }
                if (endDateInput && endDateInput.value && startDateInput) {
                    startDateInput.max = endDateInput.value;
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + / to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                    e.preventDefault();
                    const searchInput = document.querySelector('input[name="search"]');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
                
                // Escape to clear search
                if (e.key === 'Escape') {
                    const searchInput = document.querySelector('input[name="search"]');
                    if (searchInput && document.activeElement === searchInput) {
                        searchInput.value = '';
                        submitFilterForm();
                    }
                }
                
                // Ctrl/Cmd + R to reset filters (prevent default browser refresh)
                if ((e.ctrlKey || e.metaKey) && e.key === 'r' && !e.shiftKey) {
                    e.preventDefault();
                    window.location.href = '{{ route("support_tickets.index") }}';
                }
            });

            // Notification system
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                const existingNotifications = document.querySelectorAll('.notification');
                existingNotifications.forEach(notification => notification.remove());
                
                const notification = document.createElement('div');
                notification.className = `notification fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 max-w-sm ${
                    type === 'success' ? 'bg-green-600 text-white' : 
                    type === 'error' ? 'bg-red-600 text-white' : 
                    type === 'warning' ? 'bg-yellow-600 text-white' :
                    'bg-blue-600 text-white'
                }`;
                
                notification.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ? 
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                                type === 'error' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' :
                                type === 'warning' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                            }
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium">${message}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" 
                                class="text-white/80 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => notification.remove(), 300);
                    }
                }, 5000);
            }

            // Show loading overlay for form submissions
            function showLoadingOverlay() {
                const overlay = document.createElement('div');
                overlay.id = 'loadingOverlay';
                overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                overlay.innerHTML = `
                    <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                        <svg class="w-6 h-6 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-lg font-medium text-gray-900">Applying filters...</span>
                    </div>
                `;
                document.body.appendChild(overlay);
            }

            // Initialize page
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Support tickets filters initialized for user: harithelord47');
                
                // Show notification if there are active filters
                const hasActiveFilters = {{ json_encode($hasFilters) }};
                if (hasActiveFilters) {
                    showNotification('Filters are currently active. Use "Reset" to clear all filters.', 'info');
                }
            });
        </script>

        <!-- Enhanced CSS for better mobile experience and animations -->
        <style>
            /* Improve select appearance on mobile */
            @media (max-width: 640px) {
                select, input[type="text"], input[type="date"], input[type="search"] {
                    font-size: 16px; /* Prevents zoom on iOS */
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                }
                
                .grid {
                    gap: 0.75rem;
                }
                
                /* Stack form elements vertically on mobile */
                .grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4 {
                    grid-template-columns: 1fr;
                }
            }
            
            /* Custom focus styles */
            select:focus, input:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                transform: translateY(-1px);
            }
            
            /* Smooth transitions */
            select, input, button, .dot, .dot-inner {
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            /* Loading state */
            .loading {
                opacity: 0.6;
                pointer-events: none;
                cursor: not-allowed;
            }
            
            /* Better visual hierarchy */
            .filter-section {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            }
            
            /* Enhanced toggle switch */
            input[type="checkbox"]:checked + .relative .dot {
                background-color: #3b82f6;
            }
            
            input[type="checkbox"]:checked + .relative .block {
                background-color: #3b82f6;
            }
            
            /* Notification animations */
            .notification {
                animation: slideInRight 0.3s ease-out;
            }
            
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            /* Hover effects */
            button:hover, select:hover, .group:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            
            /* Active filter badges animation */
            .active-filter-badge {
                animation: fadeInUp 0.2s ease-out;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            /* Search input enhancement */
            input[name="search"]:focus {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            }
            
            /* Date input styling */
            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(0.5);
                cursor: pointer;
            }
            
            input[type="date"]::-webkit-calendar-picker-indicator:hover {
                filter: invert(0.8);
            }
        </style> 

        <!-- Enhanced Tickets Grid -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Support Tickets</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-300">
                        Showing {{ $supportTickets->count() }} of {{ $supportTickets->total() }} tickets
                    </div>
                </div>
            </div>
        
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($supportTickets as $supportTicket)
                        <div class="bg-white dark:bg-gray-900 border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:border-blue-300 dark:hover:border-blue-400 hover:shadow-lg transition-all duration-200 group">
                            <!-- Ticket Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white text-lg">Ticket #{{ $supportTicket->id }}</h3>
                                        @if (Auth::user()->hasRole('admin'))
                                            <p class="text-sm text-gray-500 dark:text-gray-300">by {{ $supportTicket->user->name }}</p>
                                        @endif
                                    </div>
                                </div>
        
                                @php
                                    $statusConfig = [
                                        'opened' => ['bg-green-100 dark:bg-green-900', 'text-green-800 dark:text-green-300', 'Open'],
                                        'closed' => ['bg-red-100 dark:bg-red-900', 'text-red-800 dark:text-red-300', 'Closed'],
                                        'admin_replied' => ['bg-blue-100 dark:bg-blue-900', 'text-blue-800 dark:text-blue-300', 'Admin Replied'],
                                        'customer_replied' => ['bg-yellow-100 dark:bg-yellow-900', 'text-yellow-800 dark:text-yellow-300', 'Customer Replied'],
                                    ];
                                    $config = $statusConfig[$supportTicket->status] ?? ['bg-gray-100 dark:bg-gray-700', 'text-gray-800 dark:text-gray-300', 'Unknown'];
                                @endphp
        
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config[0] }} {{ $config[1] }}">
                                    {{ $config[2] }}
                                </span>
                            </div>
        
                            <!-- Ticket Content -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $supportTicket->subject }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Updated {{ $supportTicket->updated_at->diffForHumans() }}</p>
                            </div>
        
                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between">
                                <a href="{{ route('support_tickets.show', $supportTicket) }}"
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </a>
        
                                <div class="flex items-center space-x-2">
                                    @if ($supportTicket->status !== 'closed' && !$supportTicket->trashed())
                                        <form method="POST" action="{{ route('support_tickets.close', $supportTicket) }}">
                                            @csrf
                                            <button type="submit" title="Close Ticket"
                                                    class="p-2 text-yellow-600 dark:text-yellow-300 bg-yellow-50 dark:bg-yellow-900 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-800 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
        
                                    @if ($supportTicket->status === 'closed' && !$supportTicket->trashed())
                                        <form method="POST" action="{{ route('support_tickets.reopen', $supportTicket) }}">
                                            @csrf
                                            <button type="submit" title="Reopen Ticket"
                                                    class="p-2 text-green-600 dark:text-green-300 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
        
                                    @if (!$supportTicket->trashed())
                                        <form method="POST" action="{{ route('support_tickets.destroy', $supportTicket) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Ticket"
                                                    onclick="return confirm('Are you sure you want to delete this ticket?')"
                                                    class="p-2 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900 rounded-lg hover:bg-red-100 dark:hover:bg-red-800 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
        
                                    @if ($supportTicket->trashed() && Auth::user()->hasRole('admin'))
                                        <form method="POST" action="{{ route('support_tickets.recover', $supportTicket) }}">
                                            @csrf
                                            <button type="submit" title="Restore Ticket"
                                                    class="p-2 text-green-600 dark:text-green-300 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-12 text-center">
                            <div class="mx-auto w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Support Tickets Found</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">There are no support tickets matching your current filters.</p>
                            <a href="{{ route('support_tickets.create') }}"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Your First Ticket
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        

        <!-- Enhanced Pagination -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <x-pagination :paginator="$supportTickets" />
        </div>
        
</div>
    

    <style>
        .dot {
            transition: transform 0.3s ease-in-out;
        }
        
        input[type="checkbox"]:checked + div .dot {
            transform: translateX(1.5rem);
            background-color: #3B82F6;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>