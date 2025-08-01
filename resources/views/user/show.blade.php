<x-app-layout>
    <x-slot name="title">
        {{ __('User Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <!-- Breadcrumb -->
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors duration-200">
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
                            <a href="{{ route('user.index') }}" 
                               class="text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors duration-200">
                                Users
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900">User Details</span>
                        </li>
                    </ol>
                </nav>

                <!-- Page Title & Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">User Profile</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage user information and monitor activity</p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex space-x-3">
                        <a href="{{ route('user.edit', $user->id) }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete User
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Information Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-xl font-bold text-white">User Information</h2>
                                    <p class="text-indigo-100 text-sm">Personal details and contact information</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex flex-col">
                                        <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Full Name</label>
                                        <span class="mt-1 text-lg font-medium text-gray-900">{{ $user->name }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Email Address</label>
                                        <span class="mt-1 text-lg text-gray-900 break-all">{{ $user->email }}</span>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex flex-col">
                                        <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Phone Number</label>
                                        <span class="mt-1 text-lg text-gray-900">
                                            {{ $user->phone ?? 'Not provided' }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Address</label>
                                        <span class="mt-1 text-lg text-gray-900">
                                            {{ $user->address ?? 'Not provided' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional User Info -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-500">User ID</span>
                                        <span class="text-sm font-bold text-gray-900">#{{ $user->id }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-500">Joined</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-500">Status</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-sm font-medium text-gray-500">Last Updated</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $user->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-bold text-white">Usage Statistics</h3>
                                    <p class="text-green-100 text-sm">Platform activity overview</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Transactions -->
                                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Transactions</p>
                                            <p class="text-xs text-gray-500">Total records</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-600">{{ number_format($user->transactions->count()) }}</span>
                                </div>

                                <!-- Categories -->
                                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg border border-purple-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Categories</p>
                                            <p class="text-xs text-gray-500">Created categories</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-purple-600">{{ number_format($user->categories->count()) }}</span>
                                </div>

                                <!-- Budgets -->
                                <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg border border-orange-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Budgets</p>
                                            <p class="text-xs text-gray-500">Active budgets</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-orange-600">{{ number_format($user->budgets->count()) }}</span>
                                </div>

                                <!-- Wallets -->
                                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Wallets</p>
                                            <p class="text-xs text-gray-500">Connected wallets</p>
                                        </div>
                                    </div>
                                    <span class="text-2xl font-bold text-green-600">{{ number_format($user->wallets->count()) }}</span>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Quick Actions</h4>
                                <div class="space-y-2">
                                    <a href="#" class="block w-full px-4 py-2 text-sm text-center text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        View Transactions
                                    </a>
                                    <a href="#" class="block w-full px-4 py-2 text-sm text-center text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        Send Message
                                    </a>
                                    <a href="#" class="block w-full px-4 py-2 text-sm text-center text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                        View Activity Log
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Analytics Section -->
            <div class="mt-8">
                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activity & Analytics</h3>
                        <p class="text-sm text-gray-500">User engagement and platform usage insights</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Last Login -->
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900">Last Login</h4>
                                <p class="text-2xl font-bold text-gray-700 mt-1">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                </p>
                            </div>

                            <!-- Account Age -->
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900">Account Age</h4>
                                <p class="text-2xl font-bold text-gray-700 mt-1">
                                    {{ $user->created_at->diffInDays() }} days
                                </p>
                            </div>

                            <!-- Total Records -->
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 3a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-gray-900">Total Records</h4>
                                <p class="text-2xl font-bold text-gray-700 mt-1">
                                    {{ number_format($user->transactions->count() + $user->categories->count() + $user->budgets->count() + $user->wallets->count()) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>