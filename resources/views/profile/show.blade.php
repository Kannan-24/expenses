<x-app-layout>
    <x-slot name="title">
        {{ __('User Profile') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="w-full mx-auto max-w-7xl p-4 lg:p-2 space-y-6">

        <!-- Enhanced Header Section -->
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10 dark:opacity-20"></div>
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-white opacity-5 dark:opacity-10 rounded-full"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white opacity-5 dark:opacity-10 rounded-full"></div>
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Profile Picture -->
                        <div class="relative">
                            @if ($user->profile_photo)
                                <img class="w-24 h-24 lg:w-32 lg:h-32 rounded-full object-cover ring-4 ring-white ring-opacity-30 shadow-xl" 
                                     src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" />
                            @else
                                <div class="w-24 h-24 lg:w-32 lg:h-32 bg-gradient-to-br from-blue-400 to-purple-600 dark:from-blue-500 dark:to-purple-700 rounded-full flex items-center justify-center ring-4 ring-white ring-opacity-30 shadow-xl">
                                    <span class="text-white font-bold text-3xl lg:text-4xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <!-- Online Status Indicator -->
                            <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 dark:bg-green-400 rounded-full border-4 border-white shadow-lg"></div>
                        </div>
                        
                        <div>
                            <h1 class="text-3xl lg:text-4xl font-bold mb-2">{{ $user->name }}</h1>
                            <p class="text-indigo-200 dark:text-indigo-300 text-lg">{{ $user->email }}</p>
                            <div class="flex items-center space-x-4 mt-3 text-indigo-100 dark:text-indigo-200">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z"></path>
                                    </svg>
                                    <span class="text-sm">Member since {{ $user->created_at->format('M Y') }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm">Last seen {{ $user->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Action Buttons -->
                    <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-100 text-indigo-700 dark:text-indigo-800 font-semibold rounded-xl hover:bg-indigo-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('account.settings') }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-10 text-white font-semibold rounded-xl hover:bg-opacity-30 dark:hover:bg-opacity-20 transition-all duration-200 border border-white border-opacity-30 dark:border-opacity-20">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Account Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Profile Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-blue-500 dark:border-blue-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Account Status</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">Active</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Verified account</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-green-500 dark:border-green-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Profile Completion</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $user->phone && $user->address ? '100%' : ($user->phone || $user->address ? '75%' : '50%') }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $user->phone && $user->address ? 'Complete' : 'Needs attention' }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-purple-500 dark:border-purple-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Member Since</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $user->created_at->diffForHumans(null, true) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Profile Details Section -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-600 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Profile Information</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Your personal account details and information</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Personal Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Full Name</label>
                                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $user->name }}</span>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address</label>
                                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $user->email }}</span>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Phone Number</label>
                                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $user->phone ?? 'Not provided' }}
                                        </span>
                                        @if(!$user->phone)
                                            <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                                Missing
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Address</label>
                                    <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <span class="text-gray-900 dark:text-white font-medium">
                                                {{ $user->address ?? 'Not provided' }}
                                            </span>
                                            @if(!$user->address)
                                                <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                                    Missing
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Details -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Account Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Account Created</label>
                                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-gray-900 dark:text-white font-medium block">{{ $user->created_at->format('M d, Y') }}</span>
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Last Updated</label>
                                    <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <div>
                                            <span class="text-gray-900 dark:text-white font-medium block">{{ $user->updated_at->format('M d, Y') }}</span>
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->updated_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Quick Actions Card -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('profile.edit') }}" 
                           class="w-full flex items-center p-3 text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 group">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 group-hover:bg-blue-200 dark:group-hover:bg-blue-800 rounded-lg mr-3 transition-colors">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Edit Profile</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Update your information</p>
                            </div>
                        </a>

                        <a href="{{ route('account.settings') }}" 
                           class="w-full flex items-center p-3 text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-green-50 dark:hover:bg-green-900 hover:text-green-600 dark:hover:text-green-400 transition-all duration-200 group">
                            <div class="p-2 bg-green-100 dark:bg-green-900 group-hover:bg-green-200 dark:group-hover:bg-green-800 rounded-lg mr-3 transition-colors">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Account Settings</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Security & preferences</p>
                            </div>
                        </a>

                        @if(!$user->phone || !$user->address)
                        <div class="w-full flex items-center p-3 text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-900 rounded-lg border border-amber-200 dark:border-amber-700">
                            <div class="p-2 bg-amber-100 dark:bg-amber-800 rounded-lg mr-3">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Complete Profile</p>
                                <p class="text-sm text-amber-600 dark:text-amber-400">Add missing information</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Tips Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 rounded-xl border border-blue-200 dark:border-blue-700 p-6">
                    <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Profile Tips
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <p class="text-blue-800 dark:text-blue-200">Keep your profile information up to date for better security</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <p class="text-blue-800 dark:text-blue-200">Add a profile photo to personalize your account</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <p class="text-blue-800 dark:text-blue-200">Review your privacy settings regularly</p>
                        </div>
                    </div>
                </div>

                <!-- Security Status Card -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Security Status
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-2 bg-green-50 dark:bg-green-900 rounded-lg">
                            <span class="text-sm font-medium text-green-800 dark:text-green-200">Email Verified</span>
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Password Strong</span>
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                            <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">2FA Available</span>
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>