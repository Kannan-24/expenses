<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'expenses') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js-->
    <script src="//unpkg.com/alpinejs" defer></script>

    @isset($head)
        {{ $head }}
    @endisset

    <x-google-analytics-head />
</head>

<body class="font-sans antialiased bg-blue-200 min-h-screen">
    <x-google-analytics-body />

    <div class="pt-16 md:pt-0 bg-blue-200">
        {{-- @if (Route::currentRouteName() !== 'welcome')
            @include('layouts.navigation')
        @endif --}}

        <div id="message-alert"
            class="fixed inset-x-2 bottom-5 right-2 left-2 sm:inset-x-0 sm:right-5 sm:left-auto z-50 transition-all ease-in-out duration-300 message-alert">
            <!-- Message Alert -->
            @if (session()->has('response'))
                @php
                    $message = session()->get('response') ?? [];
                    $status = match ($message['status'] ?? 'info') {
                        'success' => 'green',
                        'error' => 'red',
                        'warning' => 'yellow',
                        'info' => 'blue',
                        default => 'gray',
                    };
                @endphp

                <div class="bg-{{ $status }}-100 border border-{{ $status }}-400 text-{{ $status }}-700 px-3 py-2 rounded relative w-full sm:w-72 ms-auto my-1 flex items-center text-sm sm:text-base"
                    role="alert">
                    <span class="block sm:inline">{{ $message['message'] }}</span>
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative w-full sm:w-72 ms-auto my-1 flex items-center text-sm sm:text-base"
                        role="alert">
                        <span class="block sm:inline">{{ $error }}</span>
                    </div>
                @endforeach
            @endif
        </div>

        @isset($header)
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 py-4 sm:py-6 w-full sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <div x-data="{ 
            sidebarOpen: false,
            notificationOpen: false,
            profileOpen: false,
            currentTime: new Date().toLocaleString(),
            
            init() {
                // Update time every minute
                setInterval(() => {
                    this.currentTime = new Date().toLocaleString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }, 60000);
                
                // Close sidebar on route change (for mobile)
                this.$nextTick(() => {
                    document.addEventListener('click', (e) => {
                        if (e.target.closest('a[href]') && window.innerWidth < 1024) {
                            this.sidebarOpen = false;
                        }
                    });
                });
            },
            
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            }
        }">
        
            <!-- Mobile Overlay -->
            <div x-show="sidebarOpen" 
                 x-transition.opacity.duration.300ms 
                 class="fixed inset-0 z-[60] bg-black/50 lg:hidden" 
                 @click="sidebarOpen = false">
            </div>
        
            <!-- Enhanced Unified Sidebar -->
            <aside x-show="sidebarOpen || window.innerWidth >= 1024"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                   class="fixed top-0 left-0 z-[70] w-80 h-screen bg-white shadow-2xl border-r border-gray-200 transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col overflow-hidden"
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="-translate-x-full"
                   x-transition:enter-end="translate-x-0"
                   x-transition:leave="transition ease-in duration-300"
                   x-transition:leave-start="translate-x-0"
                   x-transition:leave-end="-translate-x-full">
        
                <!-- Sidebar Header -->
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 p-6 border-b border-blue-500">
                    <div class="flex items-center justify-between mb-4">
                        <!-- Logo and Brand -->
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                            <div class="p-2 bg-white/20 rounded-xl group-hover:bg-white/30 transition-all duration-200">
                                <x-application-logo class="w-8 h-8 text-white" />
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white group-hover:text-blue-100 transition-colors">
                                    Duo Dev Expenses
                                </h1>
                                <p class="text-blue-200 text-sm">Financial Management</p>
                            </div>
                        </a>
                        
                        <!-- Mobile Close Button -->
                        <button @click="sidebarOpen = false" 
                                class="lg:hidden p-2 text-white/80 hover:text-white hover:bg-white/20 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
        
                    <!-- User Profile Section -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3 mb-3">
                            @if (Auth::user()->profile_photo)
                                <img class="w-12 h-12 rounded-full object-cover ring-2 ring-white/30" 
                                     src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" />
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center ring-2 ring-white/30">
                                    <span class="text-white font-bold text-lg">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-semibold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-blue-200 text-sm truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <!-- Profile Dropdown Toggle -->
                            <button @click="profileOpen = !profileOpen" 
                                    class="p-1 text-white/80 hover:text-white hover:bg-white/20 rounded-lg transition-colors">
                                <svg class="w-5 h-5 transition-transform" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Quick Profile Actions -->
                        <div x-show="profileOpen" x-collapse class="space-y-2">
                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center space-x-2 w-full px-3 py-2 text-sm text-white/90 hover:text-white hover:bg-white/20 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>View Profile</span>
                            </a>
                            <a href="{{ route('account.settings') }}" 
                               class="flex items-center space-x-2 w-full px-3 py-2 text-sm text-white/90 hover:text-white hover:bg-white/20 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Account Settings</span>
                            </a>
                        </div>
                        
                        <!-- Status and Time -->
                        <div class="mt-3 pt-3 border-t border-white/20">
                            <div class="flex items-center justify-between text-xs text-blue-200">
                                <div class="flex items-center space-x-1">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                    <span>Online</span>
                                </div>
                                <span x-text="currentTime">{{ now()->format('M d, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Navigation Section -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Navigation Header -->
                    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Navigation</h3>
                            
                            <!-- Notifications Button -->
                            <button @click="notificationOpen = !notificationOpen" 
                                    class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9"></path>
                                </svg>
                                @if (Auth::user()->unreadNotifications->count() > 0)
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-white">
                                            {{ Auth::user()->unreadNotifications->count() > 9 ? '9+' : Auth::user()->unreadNotifications->count() }}
                                        </span>
                                    </div>
                                @endif
                            </button>
                        </div>
                    </div>
        
                    <!-- Main Navigation Menu -->
                    <nav class="p-4 space-y-2">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                            <div class="p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                            </div>
                            <span class="ml-3 font-medium">Dashboard</span>
                            @if(request()->routeIs('dashboard'))
                                <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                            @endif
                        </a>
        
                        <!-- Core Features Section -->
                        <div class="pt-4">
                            <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Core Features</h4>
                            
                            @can('manage transactions')
                            <a href="{{ route('transactions.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('transactions.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('transactions.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Transactions</span>
                                @if(request()->routeIs('transactions.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
        
                            @can('manage categories')
                            <a href="{{ route('categories.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('categories.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Categories</span>
                                @if(request()->routeIs('categories.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
        
                            @can('manage wallets')
                            <a href="{{ route('wallets.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('wallets.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('wallets.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Wallets</span>
                                @if(request()->routeIs('wallets.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
        
                            @can('manage budgets')
                            <a href="{{ route('budgets.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('budgets.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('budgets.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Budgets</span>
                                @if(request()->routeIs('budgets.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
                        </div>
        
                        <!-- Management Section -->
                        <div class="pt-4">
                            <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Management</h4>
                            
                            @can('manage expense people')
                            <a href="{{ route('expense-people.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('expense-people.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('expense-people.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Expense People</span>
                                @if(request()->routeIs('expense-people.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
        
                            @can('generate reports')
                            <a href="{{ route('reports.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('reports.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Reports</span>
                                @if(request()->routeIs('reports.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
                        </div>
        
                        <!-- System Configuration -->
                        @if(Auth::user()->can('manage wallet types') || Auth::user()->can('manage currencies') || Auth::user()->can('manage users') || Auth::user()->can('manage roles'))
                        <div class="pt-4">
                            <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">System</h4>
                            
                            @can('manage currencies')
                            <a href="{{ route('currencies.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('currencies.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('currencies.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Currencies</span>
                                @if(request()->routeIs('currencies.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
        
                            @can('manage wallet types')
                            <a href="{{ route('wallet-types.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('wallet-types.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('wallet-types.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Wallet Types</span>
                                @if(request()->routeIs('wallet-types.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
        
                            @can('manage users')
                            <a href="{{ route('user.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('users.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Users</span>
                                @if(request()->routeIs('users.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
        
                            @can('manage roles')
                            <a href="{{ route('roles.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('roles.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('roles.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Roles</span>
                                @if(request()->routeIs('roles.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                            @endcan
                        </div>
                        @endif
        
                        <!-- Support -->
                        <div class="pt-4">
                            <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Support</h4>
                            
                            <a href="{{ route('support_tickets.index') }}" 
                               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('support_tickets.*') ? 'bg-blue-100 text-blue-700 shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                                <div class="p-2 rounded-lg {{ request()->routeIs('support_tickets.*') ? 'bg-blue-200' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 font-medium">Support Tickets</span>
                                @if(request()->routeIs('support_tickets.*'))
                                    <div class="ml-auto w-1 h-8 bg-blue-600 rounded-full"></div>
                                @endif
                            </a>
                        </div>
                    </nav>
                </div>
        
                <!-- Bottom Actions -->
                <div class="border-t border-gray-200 p-4 space-y-2">
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center px-4 py-3 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group">
                            <div class="p-2 bg-red-100 group-hover:bg-red-200 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                                </svg>
                            </div>
                            <span class="ml-3 font-medium">Sign Out</span>
                        </button>
                    </form>
                </div>
            </aside>
        
            <!-- Notifications Panel -->
            <div x-show="notificationOpen" 
                 @click.away="notificationOpen = false" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full"
                 class="fixed right-0 top-0 z-[80] w-96 h-full bg-white shadow-2xl border-l border-gray-200 flex flex-col">
                
                <!-- Notifications Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Notifications</h3>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                            <p class="text-sm text-gray-600">{{ Auth::user()->unreadNotifications->count() }} unread</p>
                        @else
                            <p class="text-sm text-gray-600">All caught up!</p>
                        @endif
                    </div>
                    <button @click="notificationOpen = false" 
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Notifications Content -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    @forelse (Auth::user()->unreadNotifications as $notification)
                        @php
                            $type = $notification->data['type'] ?? 'info';
                            $styles = [
                                'info' => 'border-blue-200 bg-blue-50',
                                'success' => 'border-green-200 bg-green-50',
                                'warning' => 'border-yellow-200 bg-yellow-50',
                                'danger' => 'border-red-200 bg-red-50',
                                'secondary' => 'border-gray-200 bg-gray-50',
                            ];
                            $style = $styles[$type] ?? $styles['info'];
                        @endphp
                        <div class="p-4 border-l-4 rounded-lg {{ $style }} hover:shadow-sm transition-shadow">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold text-gray-900 text-sm">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h4>
                                <span class="text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mb-3">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            @if (isset($notification->data['action_url']))
                                <a href="{{ $notification->data['action_url'] }}"
                                   class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                    {{ $notification->data['action_text'] ?? 'View' }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">All caught up!</h3>
                            <p class="text-gray-600">No new notifications to show.</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Notifications Footer -->
                @if (Auth::user()->unreadNotifications->count() > 0)
                    <div class="border-t border-gray-200 p-4">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Mark All as Read
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        
            <!-- Mobile Menu Button -->
            <button @click="toggleSidebar()" 
                    class="lg:hidden fixed top-4 left-4 z-[65] p-3 bg-white shadow-lg rounded-xl border border-gray-200 text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        
            <!-- Main Content Area -->
            <div class="lg:ml-80 min-h-screen">
                <!-- Your page content goes here -->
                <div class="p-4 lg:p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

        {{-- <!-- Page Content -->
        <main class="px-4 sm:px-6 lg:px-4">
            {{ $slot }}
        </main> --}}
    </div>
</body>

</html>
