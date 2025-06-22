    <div x-data="{ sidebarOpen: false }">
        <!-- Top Navigation Bar -->
        <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
            <div class="px-3 py-2 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <!-- Left: Hamburger + Logo -->
                    <div class="flex items-center">
                        <!-- Hamburger Button (only visible on small screens) -->
                        <button @click="sidebarOpen = !sidebarOpen" type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200">
                            <span class="sr-only">Open sidebar</span>
                        </button>
                        <!-- Logo -->
                        <a href="{{ route('dashboard') }}" class="flex items-center ml-2 space-x-2 lg:ml-5">
                            <x-application-logo class="w-auto h-8" />
                            <span
                                class="hidden ml-2 text-3xl font-semibold whitespace-nowrap text-gray-900 sm:inline">Expense
                                Tracker</span>
                        </a>
                    </div>
                    <!-- Right: User Dropdown -->
                    <div class="flex items-center">
                        <div class="relative" x-data="{ userDropdown: false }">
                            <button @click="userDropdown = !userDropdown" type="button"
                                class="flex items-center px-3 py-2 space-x-3 text-gray-900 bg-gray-200 rounded-full focus:ring-4 focus:ring-gray-300"
                                aria-expanded="false">
                                @if (Auth::user()->profile_photo)
                                    <img class="w-12 h-12 rounded-full"
                                        src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="User photo" />
                                @else
                                    <div
                                        class="flex items-center justify-center w-12 h-12 text-xl font-bold text-white uppercase bg-gray-500 rounded-full">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 hidden lg:block">{{ Auth::user()->email }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 transform"
                                    :class="userDropdown ? 'rotate-180' : 'rotate-0'" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userDropdown" @click.away="userDropdown = false"
                                class="absolute right-0 z-50 mt-2 transition-all duration-200 rounded-b-md shadow-lg bg-white w-52 border border-gray-200">
                                <!-- Profile -->
                                <a href="{{ route('profile.show') }}"
                                    class="flex items-center p-2 text-gray-900 hover:bg-gray-300 hover:text-blue-600 ">
                                    Profile
                                </a>

                                <hr class=" border-gray-200">

                                <!-- Account Settings -->
                                <a href="{{ route('account.settings') }}"
                                    class="flex items-center p-2 text-gray-900 hover:bg-gray-300 hover:text-blue-600 ">
                                    Account Settings
                                </a>

                                <hr class=" border-gray-200">

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full p-2 text-gray-900 hover:bg-gray-300 hover:text-blue-600 rounded-b-md"
                                        style="background-color: #ef4444;">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside id="logo-sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 mt-4 transition-transform transform bg-white border-r border-gray-200 sm:translate-x-0"
            aria-label="Sidebar">

            <div class="h-full px-3 pb-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('dashboard') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>

                    @can('manage transactions')
                        <li>
                            <a href="{{ route('transactions.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('transactions.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Transactions</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage categories')
                        {{-- Categories --}}
                        <li>
                            <a href="{{ route('categories.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('categories.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Categories</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage expense people')
                        {{-- People --}}
                        <li>
                            <a href="{{ route('expense-people.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('expense-people.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Persons</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage wallets')
                        {{-- Wallets --}}
                        <li>
                            <a href="{{ route('wallets.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('wallets.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Wallets</span>
                            </a>
                        </li>
                    @endcan

                    @can('generate reports')
                        {{-- Reports --}}
                        <li>
                            <a href="{{ route('reports.expenses') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('reports.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Reports</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage wallet types')
                        {{-- Wallet Types --}}
                        <li>
                            <a href="{{ route('wallet-types.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('wallet-types.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Wallet Types</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage currencies')
                        {{-- Currencies --}}
                        <li>
                            <a href="{{ route('currencies.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                        {{ request()->routeIs('currencies.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Currencies</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage users')
                        {{-- User Management --}}
                        <li>
                            <a href="{{ route('user.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                                {{ request()->routeIs('users.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Users</span>
                            </a>
                        </li>
                    @endcan

                    @can('manage roles')
                        {{-- Roles --}}
                        <li>
                            <a href="{{ route('roles.index') }}"
                                class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                                {{ request()->routeIs('roles.*') ? 'bg-gray-300 text-gray-900 font-semibold' : 'text-gray-900 hover:bg-gray-300 hover:text-gray-700' }}">
                                <span class="ml-3">Roles</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </aside>

    </div>
