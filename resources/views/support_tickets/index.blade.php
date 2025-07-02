<x-app-layout>
    <x-slot name="title">
        {{ __('Support Center') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class=" space-y-6">

        {{-- <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-bold">Support Center</h1>
                        </div>
                        <p class="text-blue-100 text-lg">Get help and manage your support tickets</p>
                    </div>
                    
                    <!-- Create Ticket Button -->
                    <div class="mt-4 lg:mt-0">
                        <a href="{{ route('support_tickets.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create New Ticket
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Enhanced Breadcrumb -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                        </svg>
                        <span class="text-gray-900 font-medium">Support</span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Enhanced Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Open Tickets</p>
                        <p class="text-2xl font-bold text-green-600">{{ $supportTickets->where('status', 'opened')->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Admin Replied</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $supportTickets->where('status', 'admin_replied')->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Awaiting Response</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $supportTickets->where('status', 'customer_replied')->count() }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Closed Tickets</p>
                        <p class="text-2xl font-bold text-red-600">{{ $supportTickets->where('status', 'closed')->count() }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>


        <!-- Enhanced Search and Filters -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <form method="GET" class="space-y-4">
                <!-- Main Search Bar -->
                <div class="flex items-center bg-white border border-gray-300 rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">
                    <!-- Search Icon (Left) -->
                    <div class="pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </div>
                    
                    <!-- Search Input -->
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search tickets by subject, ID, or description..."
                        class="flex-1 px-4 py-4 border-0 bg-transparent focus:ring-0 focus:outline-none text-gray-900 placeholder-gray-500 text-lg rounded-xl">
                    
                    @php $hasFilters = request('search') || request('filter') || request('start_date') || request('end_date'); @endphp
                    
                    <!-- Clear Search Button (Right) -->
                    @if($hasFilters)
                        <div class="pr-4 flex items-center">
                            <a href="{{ route('support_tickets.index') }}" 
                            class="text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-gray-100" 
                            title="Clear search">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Filter Controls -->
                <div class="flex flex-wrap items-center gap-4" x-data="{ showAdvanced: false }">
                    <!-- Quick Filters -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">Quick Filters:</span>
                        <select name="filter" onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Time</option>
                            <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                            <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>Last Month</option>
                        </select>

                        <select name="status" onchange="this.form.submit()"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Statuses</option>
                            <option value="opened" {{ request('status') == 'opened' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="admin_replied" {{ request('status') == 'admin_replied' ? 'selected' : '' }}>Admin Replied</option>
                            <option value="customer_replied" {{ request('status') == 'customer_replied' ? 'selected' : '' }}>Customer Replied</option>
                        </select>
                    </div>

                    <!-- Advanced Filters Toggle -->
                    <button type="button" @click="showAdvanced = !showAdvanced"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                        </svg>
                        Advanced Filters
                    </button>
                </div>

                <!-- Advanced Filters Panel -->
                <div x-show="showAdvanced" x-collapse class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    @if (Auth::user()->hasRole('admin'))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                            <select name="user" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="md:col-span-3 flex justify-end space-x-3 pt-4">
                        <a href="{{ route('support_tickets.index') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Reset Filters
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>

            <!-- Show Deleted Toggle -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <form method="GET" class="flex items-center">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="show_deleted" class="sr-only" {{ request('show_deleted') ? 'checked' : '' }} onchange="this.form.submit()">
                        <div class="relative">
                            <div class="block bg-gray-300 w-14 h-8 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition {{ request('show_deleted') ? 'transform translate-x-6 bg-blue-600' : '' }}"></div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">Show Deleted Tickets</span>
                    </label>
                </form>
            </div>
        </div>

        

        <!-- Enhanced Tickets Grid -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Support Tickets</h2>
                    <div class="text-sm text-gray-500">
                        Showing {{ $supportTickets->count() }} of {{ $supportTickets->total() }} tickets
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($supportTickets as $supportTicket)
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-blue-300 hover:shadow-lg transition-all duration-200 group">
                            <!-- Ticket Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg">Ticket #{{ $supportTicket->id }}</h3>
                                        @if (Auth::user()->hasRole('admin'))
                                            <p class="text-sm text-gray-500">by {{ $supportTicket->user->name }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                @php
                                    $statusConfig = [
                                        'opened' => ['bg-green-100', 'text-green-800', 'Open'],
                                        'closed' => ['bg-red-100', 'text-red-800', 'Closed'],
                                        'admin_replied' => ['bg-blue-100', 'text-blue-800', 'Admin Replied'],
                                        'customer_replied' => ['bg-yellow-100', 'text-yellow-800', 'Customer Replied'],
                                    ];
                                    $config = $statusConfig[$supportTicket->status] ?? ['bg-gray-100', 'text-gray-800', 'Unknown'];
                                @endphp
                                
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config[0] }} {{ $config[1] }}">
                                    {{ $config[2] }}
                                </span>
                            </div>

                            <!-- Ticket Content -->
                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $supportTicket->subject }}</h4>
                                <p class="text-gray-600 text-sm mb-3">Updated {{ $supportTicket->updated_at->diffForHumans() }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between">
                                <a href="{{ route('support_tickets.show', $supportTicket) }}"
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
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
                                                    class="p-2 text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
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
                                                    class="p-2 text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
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
                                                    class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
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
                                                    class="p-2 text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
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
                        <div class="col-span-full bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                            <div class="mx-auto w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Support Tickets Found</h3>
                            <p class="text-gray-600 mb-6">There are no support tickets matching your current filters.</p>
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
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
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