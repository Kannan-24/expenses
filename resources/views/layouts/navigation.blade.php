<!-- Mobile Overlay -->
<div x-show="sidebarOpen" 
x-transition.opacity.duration.300ms 
class="fixed inset-0 z-[60] bg-black/50 lg:hidden" 
@click="sidebarOpen = false">
</div>

<!-- Enhanced Unified Sidebar -->
<aside x-show="sidebarOpen || window.innerWidth >= 1024"
  :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
  class="fixed top-0 left-0 z-[70] w-80 h-screen bg-white dark:bg-gray-900 shadow-2xl border-r border-gray-200 dark:border-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col overflow-hidden"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="-translate-x-full"
  x-transition:enter-end="translate-x-0"
  x-transition:leave="transition ease-in duration-300"
  x-transition:leave-start="translate-x-0"
  x-transition:leave-end="-translate-x-full">


    <!-- Sidebar Header -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 p-6 border-b border-blue-500 dark:border-blue-600">
        <div class="flex items-center justify-between mb-4">
            <!-- Logo and Brand -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                <div class="p-2 bg-white/20 dark:bg-white/10 rounded-xl group-hover:bg-white/30 dark:group-hover:bg-white/20 ">
                    <x-application-logo class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white group-hover:text-blue-100 dark:group-hover:text-blue-200 ">
                        Duo Dev Expenses
                    </h1>
                    <p class="text-blue-200 dark:text-blue-300 text-sm">Financial Management</p>
                </div>
            </a>
            
            <!-- Mobile Close Button -->
            <button @click="sidebarOpen = false" 
                    class="lg:hidden p-2 text-white/80 hover:text-white hover:bg-white/20 dark:hover:bg-white/10 rounded-lg ">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    
        <!-- User Profile Section -->
        <div class="bg-white/10 dark:bg-white/5 backdrop-blur-sm rounded-xl p-4">
            <div class="flex items-center space-x-3 mb-3">
                @if (Auth::user()->profile_photo)
                    <img class="w-12 h-12 rounded-full object-cover ring-2 ring-white/30 dark:ring-white/20" 
                        src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" />
                @else
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-600 dark:from-blue-500 dark:to-purple-700 rounded-full flex items-center justify-center ring-2 ring-white/30 dark:ring-white/20">
                        <span class="text-white font-bold text-lg">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-white font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-blue-200 dark:text-blue-300 text-sm truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <!-- Profile Dropdown Toggle -->
                <button @click="profileOpen = !profileOpen" 
                        class="p-1 text-white/80 hover:text-white hover:bg-white/20 dark:hover:bg-white/10 rounded-lg ">
                    <svg class="w-5 h-5 transition-transform" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Quick Profile Actions -->
            <div x-show="profileOpen" x-collapse class="space-y-2">
                <a href="{{ route('profile.show') }}" 
                class="flex items-center space-x-2 w-full px-3 py-2 text-sm text-white/90 hover:text-white hover:bg-white/20 dark:hover:bg-white/10 rounded-lg ">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>View Profile</span>
                </a>
                <a href="{{ route('account.settings') }}" 
                class="flex items-center space-x-2 w-full px-3 py-2 text-sm text-white/90 hover:text-white hover:bg-white/20 dark:hover:bg-white/10 rounded-lg ">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Account Settings</span>
                </a>
            </div>
            
            <!-- Status and Time -->
            <div class="mt-3 pt-3 border-t border-white/20 dark:border-white/10">
                <div class="flex items-center justify-between text-xs text-blue-200 dark:text-blue-300">
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 bg-green-400 dark:bg-green-500 rounded-full animate-pulse"></div>
                        <span>Online</span>
                    </div>
                    <span>{{ now()->format('D d M Y, h:i A ') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <div class="flex-1 overflow-y-auto">
        <!-- Navigation Header -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Navigation</h3>
                
                <div>
                    <!-- Theme Toggle Button -->
                    <button @click='darkMode = !darkMode' type="button" 
                        class="inline-flex items-center justify-center w-8 h-8 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/50 rounded-lg focus:outline-none" role="button" aria-label="Toggle theme">
                        <!-- Sun icon - shown in dark mode -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sun w-5 h-5 hidden dark:block" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                            <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
                        </svg>
                        <!-- Moon icon - shown in light mode -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-moon w-5 h-5 block dark:hidden" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                        </svg>
                    </button>

                    <!-- Notifications Button -->
                    <button @click="notificationOpen = !notificationOpen" 
                            class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/50 rounded-lg ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9"></path>
                        </svg>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 dark:bg-red-600 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-white">
                                    {{ Auth::user()->unreadNotifications->count() > 9 ? '9+' : Auth::user()->unreadNotifications->count() }}
                                </span>
                            </div>
                        @endif
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Navigation Menu -->
        <nav class="p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
                class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('dashboard') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                <div class="p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path stroke="currentColor" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5ZM14 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V5ZM4 16a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3ZM14 13a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-6Z"></path> </g>
                    </svg>
                </div>
                <span class="ml-3 font-medium">Dashboard</span>
                @if(request()->routeIs('dashboard'))
                    <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                @endif
            </a>

            <!-- Core Features Section -->
            <div class="pt-4">
                <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Core Features</h4>
                
                @can('manage transactions')
                <a href="{{ route('transactions.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('transactions.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 transition-all' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('transactions.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9375 1.25H12.0625C14.1308 1.24998 15.7678 1.24997 17.0485 1.44129C18.3725 1.63907 19.4223 2.05481 20.2395 2.96274C21.0464 3.85936 21.4066 4.99222 21.5798 6.42355C21.75 7.83014 21.75 9.63498 21.75 11.9478V12.0522C21.75 14.365 21.75 16.1699 21.5798 17.5765C21.4066 19.0078 21.0464 20.1406 20.2395 21.0373C19.4223 21.9452 18.3725 22.3609 17.0485 22.5587C15.7678 22.75 14.1308 22.75 12.0625 22.75H11.9375C9.8692 22.75 8.23221 22.75 6.95147 22.5587C5.62747 22.3609 4.57769 21.9452 3.76055 21.0373C2.95359 20.1406 2.59338 19.0078 2.42018 17.5765C2.24998 16.1699 2.24999 14.365 2.25 12.0522V11.9478C2.24999 9.63499 2.24998 7.83014 2.42018 6.42355C2.59338 4.99222 2.95359 3.85936 3.76055 2.96274C4.57769 2.05481 5.62747 1.63907 6.95147 1.44129C8.23221 1.24997 9.86922 1.24998 11.9375 1.25ZM7.17309 2.92483C6.04626 3.09316 5.37637 3.40965 4.87549 3.96619C4.36443 4.53404 4.06563 5.31193 3.90932 6.60374C3.7513 7.90972 3.75 9.62385 3.75 12C3.75 14.3762 3.7513 16.0903 3.90932 17.3963C4.06563 18.6881 4.36443 19.466 4.87549 20.0338C5.37637 20.5903 6.04626 20.9068 7.17309 21.0752C8.33029 21.248 9.8552 21.25 12 21.25C14.1448 21.25 15.6697 21.248 16.8269 21.0752C17.9537 20.9068 18.6236 20.5903 19.1245 20.0338C19.6356 19.466 19.9344 18.6881 20.0907 17.3963C20.2487 16.0903 20.25 14.3762 20.25 12C20.25 9.62385 20.2487 7.90972 20.0907 6.60374C19.9344 5.31193 19.6356 4.53404 19.1245 3.96619C18.6236 3.40965 17.9537 3.09316 16.8269 2.92483C15.6697 2.75196 14.1448 2.75 12 2.75C9.8552 2.75 8.33029 2.75196 7.17309 2.92483ZM8.91612 5.24994C8.9438 5.24997 8.97176 5.25 9 5.25H15C15.0282 5.25 15.0562 5.24997 15.0839 5.24994C15.4647 5.24954 15.7932 5.24919 16.0823 5.32667C16.8588 5.53472 17.4653 6.1412 17.6733 6.91766C17.7508 7.2068 17.7505 7.53533 17.7501 7.91612C17.75 7.9438 17.75 7.97176 17.75 8C17.75 8.02824 17.75 8.0562 17.7501 8.08389C17.7505 8.46468 17.7508 8.7932 17.6733 9.08234C17.4653 9.8588 16.8588 10.4653 16.0823 10.6733C15.7932 10.7508 15.4647 10.7505 15.0839 10.7501C15.0562 10.75 15.0282 10.75 15 10.75H9C8.97176 10.75 8.9438 10.75 8.91612 10.7501C8.53533 10.7505 8.2068 10.7508 7.91766 10.6733C7.1412 10.4653 6.53472 9.8588 6.32667 9.08234C6.24919 8.7932 6.24954 8.46468 6.24994 8.08389C6.24997 8.0562 6.25 8.02824 6.25 8C6.25 7.97176 6.24997 7.9438 6.24994 7.91612C6.24954 7.53533 6.24919 7.2068 6.32667 6.91766C6.53472 6.1412 7.1412 5.53472 7.91766 5.32667C8.2068 5.24919 8.53533 5.24954 8.91612 5.24994ZM9 6.75C8.48673 6.75 8.37722 6.75644 8.30589 6.77556C8.04707 6.84491 7.84491 7.04707 7.77556 7.30589C7.75644 7.37722 7.75 7.48673 7.75 8C7.75 8.51327 7.75644 8.62278 7.77556 8.69412C7.84491 8.95293 8.04707 9.1551 8.30589 9.22445C8.37722 9.24356 8.48673 9.25 9 9.25H15C15.5133 9.25 15.6228 9.24356 15.6941 9.22445C15.9529 9.1551 16.1551 8.95293 16.2244 8.69412C16.2436 8.62278 16.25 8.51327 16.25 8C16.25 7.48673 16.2436 7.37722 16.2244 7.30589C16.1551 7.04707 15.9529 6.84491 15.6941 6.77556C15.6228 6.75644 15.5133 6.75 15 6.75H9Z" fill="currentColor"></path> <path d="M9 13C9 13.5523 8.55229 14 8 14C7.44772 14 7 13.5523 7 13C7 12.4477 7.44772 12 8 12C8.55229 12 9 12.4477 9 13Z" fill="currentColor"></path> <path d="M9 17C9 17.5523 8.55229 18 8 18C7.44772 18 7 17.5523 7 17C7 16.4477 7.44772 16 8 16C8.55229 16 9 16.4477 9 17Z" fill="currentColor"></path> <path d="M13 13C13 13.5523 12.5523 14 12 14C11.4477 14 11 13.5523 11 13C11 12.4477 11.4477 12 12 12C12.5523 12 13 12.4477 13 13Z" fill="currentColor"></path> <path d="M13 17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17C11 16.4477 11.4477 16 12 16C12.5523 16 13 16.4477 13 17Z" fill="currentColor"></path> <path d="M17 13C17 13.5523 16.5523 14 16 14C15.4477 14 15 13.5523 15 13C15 12.4477 15.4477 12 16 12C16.5523 12 17 12.4477 17 13Z" fill="currentColor"></path> <path d="M17 17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17C15 16.4477 15.4477 16 16 16C16.5523 16 17 16.4477 17 17Z" fill="currentColor"></path> </g>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Transactions</span>
                    @if(request()->routeIs('transactions.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan

                @can('manage categories')
                <a href="{{ route('categories.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('categories.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Categories</span>
                    @if(request()->routeIs('categories.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan

                @can('manage wallets')
                <a href="{{ route('wallets.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('wallets.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('wallets.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Wallets</span>
                    @if(request()->routeIs('wallets.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan

                @can('manage budgets')
                <a href="{{ route('budgets.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('budgets.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('budgets.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Budgets</span>
                    @if(request()->routeIs('budgets.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan
            </div>

            <!-- Management Section -->
            <div class="pt-4">
                <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Management</h4>
                
                @can('manage expense people')
                <a href="{{ route('expense-people.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('expense-people.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('expense-people.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg viewBox="0 0 16 16" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-people"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"></path> </g></svg>
                    </div>
                    <span class="ml-3 font-medium">Expense People</span>
                    @if(request()->routeIs('expense-people.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan

                @can('generate reports')
                <a href="{{ route('reports.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('reports.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Reports</span>
                    @if(request()->routeIs('reports.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
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
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('currencies.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('currencies.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Currencies</span>
                    @if(request()->routeIs('currencies.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan

                @can('manage wallet types')
                <a href="{{ route('wallet-types.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('wallet-types.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('wallet-types.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Wallet Types</span>
                    @if(request()->routeIs('wallet-types.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan

                @can('manage users')
                <a href="{{ route('user.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('users.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Users</span>
                    @if(request()->routeIs('users.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan

                @can('manage roles')
                <a href="{{ route('roles.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('roles.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('roles.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Roles</span>
                    @if(request()->routeIs('roles.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
                @endcan
            </div>
            @endif

            <!-- Support -->
            <div class="pt-4">
                <h4 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Support</h4>
                
                <a href="{{ route('support_tickets.index') }}" 
                    class="flex items-center px-4 py-3 rounded-xl  group {{ request()->routeIs('support_tickets.*') ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('support_tickets.*') ? 'bg-blue-200 dark:bg-blue-800' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50' }} ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium">Support Tickets</span>
                    @if(request()->routeIs('support_tickets.*'))
                        <div class="ml-auto w-1 h-8 bg-blue-600 dark:bg-blue-400 rounded-full"></div>
                    @endif
                </a>
            </div>
        </nav>
    </div>

    <!-- Bottom Actions -->
    <div class="border-t border-gray-300 p-4 space-y-2 dark:border-t dark:border-gray-700">
    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" 
            class="w-full flex items-center px-4 py-3 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/50 hover:bg-red-100 dark:hover:bg-red-900 rounded-xl group">
            <div class="p-2 bg-red-100 dark:bg-red-800 group-hover:bg-red-200 dark:group-hover:bg-red-700 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 20.7499H6C5.65324 20.7647 5.30697 20.7109 4.98101 20.5917C4.65505 20.4725 4.3558 20.2902 4.10038 20.0552C3.84495 19.8202 3.63837 19.5371 3.49246 19.2222C3.34654 18.9073 3.26415 18.5667 3.25 18.2199V5.77994C3.26415 5.43316 3.34654 5.09256 3.49246 4.77765C3.63837 4.46274 3.84495 4.17969 4.10038 3.9447C4.3558 3.70971 4.65505 3.52739 4.98101 3.40818C5.30697 3.28896 5.65324 3.23519 6 3.24994H9C9.19891 3.24994 9.38968 3.32896 9.53033 3.46961C9.67098 3.61027 9.75 3.80103 9.75 3.99994C9.75 4.19886 9.67098 4.38962 9.53033 4.53027C9.38968 4.67093 9.19891 4.74994 9 4.74994H6C5.70307 4.72412 5.4076 4.81359 5.17487 4.99977C4.94213 5.18596 4.78999 5.45459 4.75 5.74994V18.2199C4.78999 18.5153 4.94213 18.7839 5.17487 18.9701C5.4076 19.1563 5.70307 19.2458 6 19.2199H9C9.19891 19.2199 9.38968 19.299 9.53033 19.4396C9.67098 19.5803 9.75 19.771 9.75 19.9699C9.75 20.1689 9.67098 20.3596 9.53033 20.5003C9.38968 20.6409 9.19891 20.7199 9 20.7199V20.7499Z" fill="currentColor"></path> <path d="M16 16.7499C15.9015 16.7504 15.8038 16.7312 15.7128 16.6934C15.6218 16.6556 15.5392 16.6 15.47 16.5299C15.3296 16.3893 15.2507 16.1987 15.2507 15.9999C15.2507 15.8012 15.3296 15.6105 15.47 15.4699L18.94 11.9999L15.47 8.52991C15.3963 8.46125 15.3372 8.37845 15.2962 8.28645C15.2552 8.19445 15.2332 8.09513 15.2314 7.99443C15.2296 7.89373 15.2482 7.7937 15.2859 7.70031C15.3236 7.60692 15.3797 7.52209 15.451 7.45087C15.5222 7.37965 15.607 7.32351 15.7004 7.28579C15.7938 7.24807 15.8938 7.22954 15.9945 7.23132C16.0952 7.23309 16.1945 7.25514 16.2865 7.29613C16.3785 7.33712 16.4613 7.39622 16.53 7.46991L20.53 11.4699C20.6705 11.6105 20.7493 11.8012 20.7493 11.9999C20.7493 12.1987 20.6705 12.3893 20.53 12.5299L16.53 16.5299C16.4608 16.6 16.3782 16.6556 16.2872 16.6934C16.1962 16.7312 16.0985 16.7504 16 16.7499Z" fill="currentColor"></path> <path d="M20 12.75H9C8.80109 12.75 8.61032 12.671 8.46967 12.5303C8.32902 12.3897 8.25 12.1989 8.25 12C8.25 11.8011 8.32902 11.6103 8.46967 11.4697C8.61032 11.329 8.80109 11.25 9 11.25H20C20.1989 11.25 20.3897 11.329 20.5303 11.4697C20.671 11.6103 20.75 11.8011 20.75 12C20.75 12.1989 20.671 12.3897 20.5303 12.5303C20.3897 12.671 20.1989 12.75 20 12.75Z" fill="currentColor"></path> </g>
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
    class="fixed right-0 top-0 z-[80] w-96 h-full bg-white dark:bg-gray-900 shadow-2xl border-l border-gray-200 dark:border-gray-700 flex flex-col">

    <!-- Notifications Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800">
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Notifications</h3>
            @if (Auth::user()->unreadNotifications->count() > 0)
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->unreadNotifications->count() }} unread</p>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-400">All caught up!</p>
            @endif
        </div>
        <button @click="notificationOpen = false" 
                class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
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
                    'info' => 'border-blue-200 bg-blue-50 dark:border-blue-500/30 dark:bg-blue-500/10',
                    'success' => 'border-green-200 bg-green-50 dark:border-green-500/30 dark:bg-green-500/10',
                    'warning' => 'border-yellow-200 bg-yellow-50 dark:border-yellow-500/30 dark:bg-yellow-500/10',
                    'danger' => 'border-red-200 bg-red-50 dark:border-red-500/30 dark:bg-red-500/10',
                    'secondary' => 'border-gray-200 bg-gray-50 dark:border-gray-500/30 dark:bg-gray-500/10',
                ];
                $style = $styles[$type] ?? $styles['info'];
            @endphp
            <div class="p-4 border-l-4 rounded-lg {{ $style }} hover:shadow-sm transition-shadow">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">
                        {{ $notification->data['title'] ?? 'Notification' }}
                    </h4>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">
                    {{ $notification->data['message'] ?? '' }}
                </p>
                @if (isset($notification->data['action_url']))
                    <a href="{{ $notification->data['action_url'] }}"
                       class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-white">
                        {{ $notification->data['action_text'] ?? 'View' }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">All caught up!</h3>
                <p class="text-gray-600 dark:text-gray-400">No new notifications to show.</p>
            </div>
        @endforelse
    </div>

    <!-- Notifications Footer -->
    @if (Auth::user()->unreadNotifications->count() > 0)
    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                Mark All as Read
            </button>
        </form>
    </div>
    @endif
</div>


<!-- Mobile Menu Button -->
<button @click="toggleSidebar()" 
   class="lg:hidden fixed top-4 left-4 z-[65] p-3 bg-white shadow-lg rounded-xl border border-gray-200 text-gray-600 hover:text-blue-600 hover:bg-blue-50 ">
    <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
    <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
</button>