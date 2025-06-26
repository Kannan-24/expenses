<div x-data="{ sidebarOpen: false }">
    <nav class="fixed top-0 z-80 w-full p-1 bg-white border-b border-gray-200 shadow">
        <div class="px-4 py-2 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <button x-show="!sidebarOpen" @click="sidebarOpen = true" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    x-cloak>
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <x-application-logo class="w-auto h-8" />
                    <span class="hidden text-2xl font-semibold text-gray-900 sm:inline">Expense Tracker</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <a href="{{ route('profile.show') }}" class="focus:outline-none flex items-center space-x-2">
                        @if (Auth::user()->profile_photo)
                            <img class="w-10 h-10 rounded-full"
                                src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="User photo" />
                        @else
                            <div
                                class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white uppercase bg-gray-500 rounded-full">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="hidden sm:flex flex-col items-start">
                            <span class="text-sm font-medium text-gray-900">
                                {{ Auth::user()->name }}
                            </span>
                            <span class="text-xs text-gray-500 hidden sm:inline">{{ Auth::user()->email }}</span>
                        </div>
                    </a>
                </div>
                <a href="{{ route('account.settings') }}" class="text-gray-600 hover:text-blue-600">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <circle cx="12" cy="12" r="3" stroke="#1C274C" stroke-width="1.5"></circle>
                            <path
                                d="M3.66122 10.6392C4.13377 10.9361 4.43782 11.4419 4.43782 11.9999C4.43781 12.558 4.13376 13.0638 3.66122 13.3607C3.33966 13.5627 3.13248 13.7242 2.98508 13.9163C2.66217 14.3372 2.51966 14.869 2.5889 15.3949C2.64082 15.7893 2.87379 16.1928 3.33973 16.9999C3.80568 17.8069 4.03865 18.2104 4.35426 18.4526C4.77508 18.7755 5.30694 18.918 5.83284 18.8488C6.07287 18.8172 6.31628 18.7185 6.65196 18.5411C7.14544 18.2803 7.73558 18.2699 8.21895 18.549C8.70227 18.8281 8.98827 19.3443 9.00912 19.902C9.02332 20.2815 9.05958 20.5417 9.15224 20.7654C9.35523 21.2554 9.74458 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8478 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.9021C15.0117 19.3443 15.2977 18.8281 15.7811 18.549C16.2644 18.27 16.8545 18.2804 17.3479 18.5412C17.6837 18.7186 17.9271 18.8173 18.1671 18.8489C18.693 18.9182 19.2249 18.7756 19.6457 18.4527C19.9613 18.2106 20.1943 17.807 20.6603 17C20.8677 16.6407 21.029 16.3614 21.1486 16.1272M20.3387 13.3608C19.8662 13.0639 19.5622 12.5581 19.5621 12.0001C19.5621 11.442 19.8662 10.9361 20.3387 10.6392C20.6603 10.4372 20.8674 10.2757 21.0148 10.0836C21.3377 9.66278 21.4802 9.13092 21.411 8.60502C21.3591 8.2106 21.1261 7.80708 20.6601 7.00005C20.1942 6.19301 19.9612 5.7895 19.6456 5.54732C19.2248 5.22441 18.6929 5.0819 18.167 5.15113C17.927 5.18274 17.6836 5.2814 17.3479 5.45883C16.8544 5.71964 16.2643 5.73004 15.781 5.45096C15.2977 5.1719 15.0117 4.6557 14.9909 4.09803C14.9767 3.71852 14.9404 3.45835 14.8478 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74458 2.35523 9.35523 2.74458 9.15224 3.23463C9.05958 3.45833 9.02332 3.71848 9.00912 4.09794C8.98826 4.65566 8.70225 5.17191 8.21891 5.45096C7.73557 5.73002 7.14548 5.71959 6.65205 5.4588C6.31633 5.28136 6.0729 5.18269 5.83285 5.15108C5.30695 5.08185 4.77509 5.22436 4.35427 5.54727C4.03866 5.78945 3.80569 6.19297 3.33974 7C3.13231 7.35929 2.97105 7.63859 2.85138 7.87273"
                                stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                        </g>
                    </svg>
                </a>
                <div x-data="{ notificationOpen: false }" class="relative">
                    <button @click="notificationOpen = true"
                        class="relative p-1 text-gray-600 hover:text-blue-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-0 right-0 block h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div x-show="notificationOpen" @click.away="notificationOpen = false" x-transition
                        class="fixed top-0 right-0 z-50 w-80 mt-16 h-full bg-white border-l border-gray-200 shadow-lg flex flex-col"
                        style="display: none;">
                        <div class="flex items-center justify-between px-4 py-3 border-b">
                            <span class="font-semibold text-lg">Notifications</span>
                            <button @click="notificationOpen = false" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 overflow-y-auto p-4">
                            <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-3 rounded mb-2">
                                <div class="font-medium">No new notifications</div>
                                <div class="text-xs text-blue-600">You are all caught up!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="fixed top-0">
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-black bg-opacity-40 sm:hidden"
            @click="sidebarOpen = false" style="display: none;">
        </div>

        <aside id="logo-sidebar" x-show="sidebarOpen || window.innerWidth >= 640"
            @keydown.window.escape="sidebarOpen = false" @click.away="sidebarOpen = false"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-0 pb-32 transition-transform bg-white border-r border-gray-200
            transform sm:translate-x-0 sm:static sm:inset-0"
            aria-label="Sidebar" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" style="display: none;">
            <div class="flex items-center justify-between px-4 py-4 border-b">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <x-application-logo class="w-auto h-8" />
                    <span class="text-2xl font-semibold text-gray-900">Expense Tracker</span>
                </a>
                <button @click="sidebarOpen = false"
                    class="sm:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <ul class="text-l font-medium">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-4
                        {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                @can('manage transactions')
                    <li>
                        <a href="{{ route('transactions.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('transactions.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Transactions</span>
                        </a>
                    </li>
                @endcan
                @can('manage categories')
                    <li>
                        <a href="{{ route('categories.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Categories</span>
                        </a>
                    </li>
                @endcan
                @can('manage expense people')
                    <li>
                        <a href="{{ route('expense-people.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('expense-people.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Persons</span>
                        </a>
                    </li>
                @endcan
                @can('manage wallets')
                    <li>
                        <a href="{{ route('wallets.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('wallets.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Wallets</span>
                        </a>
                    </li>
                @endcan
                @can('generate reports')
                    <li>
                        <a href="{{ route('reports.expenses') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Reports</span>
                        </a>
                    </li>
                @endcan
                @can('manage wallet types')
                    <li>
                        <a href="{{ route('wallet-types.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('wallet-types.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Wallet Types</span>
                        </a>
                    </li>
                @endcan
                @can('manage currencies')
                    <li>
                        <a href="{{ route('currencies.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('currencies.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Currencies</span>
                        </a>
                    </li>
                @endcan
                @can('manage users')
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Users</span>
                        </a>
                    </li>
                @endcan
                @can('manage roles')
                    <li>
                        <a href="{{ route('roles.index') }}"
                            class="flex items-center px-4 py-4
                            {{ request()->routeIs('roles.*') ? 'bg-blue-50 text-blue-700 font-semibold border-l-8 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span class="ml-3">Roles</span>
                        </a>
                    </li>
                @endcan
            </ul>

            <div class="fixed bottom-0 left-0 w-64 sm:static sm:w-full z-50">
                <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-3 hover:text-red-50 bg-red-600 transition font-medium">
                        <svg class="w-5 h-5 mr-2 " fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>
    </div>
</div>
