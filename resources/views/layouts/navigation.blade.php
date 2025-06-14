<div x-data="{ sidebarOpen: false }">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-2 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <!-- Left: Hamburger + Logo -->
                <div class="flex items-center">
                    <!-- Hamburger Button (only visible on small screens) -->
                    <button @click="sidebarOpen = !sidebarOpen" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center ml-2 space-x-2 lg:ml-5">
                        <x-application-logo class="w-auto h-8" />
                        <span
                            class="hidden ml-2 text-3xl font-semibold whitespace-nowrap dark:text-white sm:inline">Expenses</span>
                    </a>
                </div>
                <!-- Right: User Dropdown -->
                <div class="flex items-center">
                    <div class="relative" x-data="{ userDropdown: false }">
                        <button @click="userDropdown = !userDropdown" type="button"
                            class="flex items-center px-3 py-2 space-x-3 text-white bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
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
                                <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                                <!-- Replace with dynamic name -->
                                <p class="text-xs text-gray-400">Admin</p> <!-- Replace with dynamic role -->
                            </div>
                            <svg class="w-4 h-4 text-gray-300 transition-transform duration-200 transform"
                                :class="userDropdown ? 'rotate-180' : 'rotate-0'" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>



                        <!-- Dropdown Menu -->
                        <div x-show="userDropdown" @click.away="userDropdown = false"
                            class="absolute right-0 z-50 px-4 py-2 mt-2 transition-all duration-200 rounded-md shadow-lg dark:bg-gray-800 w-52">

                            <!-- Profile -->
                            <a href="{{ route('profile.show') }}"
                                class="flex items-center p-2 text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400">
                                Profile
                            </a>

                            <!-- Account Settings -->
                            <a href="{{ route('account.settings') }}"
                                class="flex items-center p-2 text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400">
                                Account Settings
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full p-2 text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400">
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
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 mt-4 transition-transform transform bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 sm:translate-x-0"
        aria-label="Sidebar">

        <div class="h-full px-3 pb-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                    {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400' }}">
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('expenses.index') }}"
                        class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                    {{ request()->routeIs('expenses.*') ? 'bg-blue-500 text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400' }}">
                        <span class="ml-3">Expenses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}"
                        class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                    {{ request()->routeIs('categories.*') ? 'bg-blue-500 text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400' }}">
                        <span class="ml-3">Categories</span>
                    </a>
                </li>

                {{-- People --}}
                <li>
                    <a href="{{ route('expense-people.index') }}"
                        class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                    {{ request()->routeIs('expense-people.*') ? 'bg-blue-500 text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400' }}">
                        <span class="ml-3">Persons</span>
                    </a>
                </li>
                
                {{-- Payment Methods --}}
                <li>
                    <a href="{{ route('balance.history') }}"
                        class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                    {{ request()->routeIs('balance.*') ? 'bg-blue-500 text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400' }}">
                        <span class="ml-3">Balance</span>
                    </a>
                </li>

                {{-- Reports --}}
                <li>
                    <a href="{{ route('reports.expenses') }}"
                        class="flex items-center p-2 rounded-lg transition-transform duration-300 ease-in-out transform 
                    {{ request()->routeIs('reports.*') ? 'bg-blue-500 text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-500 dark:hover:text-blue-400' }}">
                        <span class="ml-3">Reports</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

</div>
