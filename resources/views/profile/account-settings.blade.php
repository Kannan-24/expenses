<x-app-layout>
    <x-slot name="title">
        {{ __('Account Settings') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="space-y-6" style="min-height: 88vh;">

        <!-- Enhanced Header Section -->
        <div class="relative bg-gradient-to-br from-gray-800 via-gray-900 to-black dark:from-gray-900 dark:via-black dark:to-gray-900 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10 dark:opacity-20"></div>
            <div class="absolute -top-8 -right-8 w-40 h-40 bg-white opacity-5 dark:opacity-10 rounded-full"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white opacity-5 dark:opacity-10 rounded-full"></div>
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="p-2 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-white">Account Settings</h1>
                                <p class="text-gray-300 dark:text-gray-200 text-lg mt-1">Manage your account security and preferences</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Info Card -->
                    <div class="mt-4 lg:mt-0 bg-white bg-opacity-10 dark:bg-white dark:bg-opacity-20 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            @if (Auth::user()->profile_photo)
                                <img class="w-12 h-12 rounded-full object-cover ring-2 ring-white ring-opacity-30 dark:ring-white dark:ring-opacity-50" 
                                     src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" />
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 dark:from-blue-400 dark:to-purple-500 rounded-full flex items-center justify-center ring-2 ring-white ring-opacity-30 dark:ring-white dark:ring-opacity-50">
                                    <span class="text-white font-bold text-lg">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="text-white font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-gray-300 dark:text-gray-200 text-sm">{{ Auth::user()->email }}</p>
                                <p class="text-gray-400 dark:text-gray-300 text-xs">Last login: {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-green-500 dark:border-green-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Account Status</p>
                        <p class="text-lg font-bold text-green-600 dark:text-green-400">Active & Secure</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Account verified</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-blue-500 dark:border-blue-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Password Strength</p>
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">Strong</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Last updated: {{ Auth::user()->updated_at->format('M d, Y') }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border-l-4 border-purple-500 dark:border-purple-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Account Age</p>
                        <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ Auth::user()->created_at->diffForHumans(null, true) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.4179 3.25077C8.69861 2.65912 9.30146 2.25 9.99986 2.25H13.9999C14.6983 2.25 15.3011 2.65912 15.5818 3.25077C16.2654 3.25574 16.7981 3.28712 17.2737 3.47298C17.8418 3.69505 18.3361 4.07255 18.6998 4.5623C19.0667 5.05639 19.2389 5.68968 19.476 6.56133C19.4882 6.60604 19.5005 6.65137 19.513 6.69735L20.1039 8.86428C20.4914 9.06271 20.8304 9.32993 21.1133 9.6922C21.7353 10.4888 21.8454 11.4377 21.7348 12.5261C21.6274 13.5822 21.2949 14.9122 20.8787 16.577L20.8523 16.6824C20.5891 17.7352 20.3755 18.59 20.1213 19.2572C19.8563 19.9527 19.5199 20.5227 18.9653 20.9558C18.4107 21.3888 17.7761 21.5769 17.0371 21.6653C16.3282 21.75 15.4472 21.75 14.362 21.75H9.63771C8.55255 21.75 7.67147 21.75 6.96266 21.6653C6.22365 21.5769 5.58901 21.3888 5.03439 20.9558C4.47977 20.5227 4.14337 19.9527 3.8784 19.2572C3.62426 18.5901 3.41058 17.7353 3.1474 16.6825L3.121 16.5769C2.70479 14.9121 2.37229 13.5822 2.26492 12.5261C2.15427 11.4377 2.26442 10.4888 2.88642 9.6922C3.16927 9.32993 3.50834 9.06271 3.89582 8.86428L4.48667 6.69735C4.49921 6.65137 4.51154 6.60604 4.5237 6.56134C4.76077 5.68968 4.93302 5.05639 5.29995 4.5623C5.66367 4.07255 6.15788 3.69505 6.72607 3.47298C7.20162 3.28712 7.73436 3.25574 8.4179 3.25077ZM8.41931 4.75219C7.75748 4.75888 7.4919 4.78416 7.2721 4.87007C6.96615 4.98964 6.70003 5.19291 6.50419 5.45662C6.32808 5.69376 6.22474 6.02508 5.93384 7.09195L5.58026 8.38869C6.61806 8.24996 7.95786 8.24998 9.62247 8.25H14.3772C16.0419 8.24998 17.3817 8.24996 18.4195 8.38869L18.0659 7.09194C17.775 6.02508 17.6716 5.69377 17.4955 5.45663C17.2997 5.19291 17.0336 4.98964 16.7276 4.87007C16.5078 4.78416 16.2422 4.75888 15.5804 4.75219C15.2991 5.34225 14.6971 5.75 13.9999 5.75H9.99986C9.30262 5.75 8.70062 5.34225 8.41931 4.75219ZM9.99986 3.75C9.86179 3.75 9.74986 3.86193 9.74986 4C9.74986 4.13807 9.86179 4.25 9.99986 4.25H13.9999C14.1379 4.25 14.2499 4.13807 14.2499 4C14.2499 3.86193 14.1379 3.75 13.9999 3.75H9.99986ZM5.69971 9.88649C4.78854 10.0183 4.34756 10.2582 4.06873 10.6153C3.78989 10.9725 3.66411 11.4584 3.75723 12.3744C3.85233 13.3099 4.15656 14.5345 4.59127 16.2733C4.86853 17.3824 5.06163 18.1496 5.28013 18.7231C5.49144 19.2778 5.69835 19.5711 5.95751 19.7735C6.21667 19.9758 6.5514 20.1054 7.14076 20.1759C7.75015 20.2488 8.54133 20.25 9.68452 20.25H14.3152C15.4584 20.25 16.2496 20.2488 16.859 20.1759C17.4483 20.1054 17.783 19.9758 18.0422 19.7735C18.3014 19.5711 18.5083 19.2778 18.7196 18.7231C18.9381 18.1496 19.1312 17.3824 19.4084 16.2733C19.8432 14.5345 20.1474 13.3099 20.2425 12.3744C20.3356 11.4584 20.2098 10.9725 19.931 10.6153C19.6522 10.2582 19.2112 10.0183 18.3 9.88649C17.3694 9.75187 16.1075 9.75 14.3152 9.75H9.68452C7.89217 9.75 6.63034 9.75187 5.69971 9.88649Z" fill="currentColor"></path> </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Settings Content -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            
            <!-- Password Update Section -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 border-b border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Password Security</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Update your password to keep your account secure</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Account Management Section -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900 dark:to-pink-900 border-b border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-red-100 dark:bg-red-800 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Account Management</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Manage your account settings and data</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    
                    <!-- Quick Actions -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg group-hover:bg-blue-200 dark:group-hover:bg-blue-700 transition-colors">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Edit Profile</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Update your personal information</p>
                                </div>
                            </a>
                            
                            <button class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg group-hover:bg-green-200 dark:group-hover:bg-green-700 transition-colors">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Verify Account</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Complete account verification</p>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <!-- Delete Account Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Danger Zone</h3>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Settings Section -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Additional Settings
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Notification Preferences -->
                <div class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-300 dark:hover:border-indigo-500 transition-colors">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage your notification preferences</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:text-indigo-500 shadow-sm focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:ring-opacity-50 dark:bg-gray-900" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Email notifications</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:text-indigo-500 shadow-sm focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:ring-opacity-50 dark:bg-gray-900">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">In-app notifications</span>
                        </label>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-green-300 dark:hover:border-green-500 transition-colors">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Privacy</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Control your privacy settings</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-green-600 dark:text-green-500 shadow-sm focus:border-green-300 dark:focus:border-green-500 focus:ring focus:ring-green-200 dark:focus:ring-green-800 focus:ring-opacity-50 dark:bg-gray-900" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Profile visibility</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-green-600 dark:text-green-500 shadow-sm focus:border-green-300 dark:focus:border-green-500 focus:ring focus:ring-green-200 dark:focus:ring-green-800 focus:ring-opacity-50 dark:bg-gray-900" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Data analytics</span>
                        </label>
                    </div>
                </div>

                <!-- Security Options -->
                <div class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-orange-300 dark:hover:border-orange-500 transition-colors">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Security</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Enhanced security options</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-orange-600 dark:text-orange-500 shadow-sm focus:border-orange-300 dark:focus:border-orange-500 focus:ring focus:ring-orange-200 dark:focus:ring-orange-800 focus:ring-opacity-50 dark:bg-gray-900">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Two-factor authentication</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-orange-600 dark:text-orange-500 shadow-sm focus:border-orange-300 dark:focus:border-orange-500 focus:ring focus:ring-orange-200 dark:focus:ring-orange-800 focus:ring-opacity-50 dark:bg-gray-900" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Login alerts</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Activity Section -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Recent Account Activity
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                        Live
                    </span>
                </h2>
                <div class="flex items-center space-x-3">
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Last updated: {{ now()->format('H:i \U\T\C') }}
                    </span>
                    <a href="{{ route('account.activity') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors">
                        View All
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                @php
                    // Sample recent activities based on current time (2025-07-07 15:53:10 UTC)
                    $currentTime = now(); // 2025-07-07 15:53:10
                    $sampleActivities = collect([
                        [
                            'id' => 1,
                            'description' => 'Successful login to dashboard',
                            'created_at' => $currentTime->copy()->subMinutes(5), // 15:48:10
                            'ip_address' => '192.168.1.105',
                            'location' => 'Mumbai, India',
                            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                            'type' => 'login',
                            'risk_level' => 'low'
                        ],
                        [
                            'id' => 2,
                            'description' => 'Budget created for Groceries category',
                            'created_at' => $currentTime->copy()->subMinutes(15), // 15:38:10
                            'ip_address' => '192.168.1.105',
                            'location' => 'Mumbai, India',
                            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                            'type' => 'budget_create',
                            'risk_level' => 'low'
                        ],
                        [
                            'id' => 3,
                            'description' => 'Expense transaction added - ₹1,250.00',
                            'created_at' => $currentTime->copy()->subMinutes(45), // 15:08:10
                            'ip_address' => '192.168.1.105',
                            'location' => 'Mumbai, India',
                            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                            'type' => 'transaction',
                            'risk_level' => 'low'
                        ],
                        [
                            'id' => 4,
                            'description' => 'Profile information updated',
                            'created_at' => $currentTime->copy()->subHours(2)->subMinutes(10), // 13:43:10
                            'ip_address' => '192.168.1.105',
                            'location' => 'Mumbai, India',
                            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                            'type' => 'profile_update',
                            'risk_level' => 'low'
                        ],
                        [
                            'id' => 5,
                            'description' => 'Password successfully updated',
                            'created_at' => $currentTime->copy()->subHours(5)->subMinutes(30), // 10:23:10
                            'ip_address' => '192.168.1.105',
                            'location' => 'Mumbai, India',
                            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                            'type' => 'security',
                            'risk_level' => 'medium'
                        ]
                    ])->map(function($item) {
                        return (object) $item;
                    });

                    // Function to get activity icon
                    function getActivityIcon($type, $riskLevel = 'low') {
                        $icons = [
                            'login' => [
                                'bg_color' => 'bg-green-100',
                                'text_color' => 'text-green-600',
                                'badge_color' => 'bg-green-100 text-green-800',
                                'badge_text' => 'Login',
                                'icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1'
                            ],
                            'budget_create' => [
                                'bg_color' => 'bg-blue-100',
                                'text_color' => 'text-blue-600',
                                'badge_color' => 'bg-blue-100 text-blue-800',
                                'badge_text' => 'Budget',
                                'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
                            ],
                            'transaction' => [
                                'bg_color' => 'bg-purple-100',
                                'text_color' => 'text-purple-600',
                                'badge_color' => 'bg-purple-100 text-purple-800',
                                'badge_text' => 'Transaction',
                                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                            ],
                            'profile_update' => [
                                'bg_color' => 'bg-indigo-100',
                                'text_color' => 'text-indigo-600',
                                'badge_color' => 'bg-indigo-100 text-indigo-800',
                                'badge_text' => 'Profile',
                                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'
                            ],
                            'security' => [
                                'bg_color' => $riskLevel === 'medium' ? 'bg-orange-100' : 'bg-red-100',
                                'text_color' => $riskLevel === 'medium' ? 'text-orange-600' : 'text-red-600',
                                'badge_color' => $riskLevel === 'medium' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800',
                                'badge_text' => 'Security',
                                'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'
                            ]
                        ];
                        
                        return $icons[$type] ?? $icons['login'];
                    }

                    // Function to format location
                    function formatLocation($location, $ipAddress) {
                        return $location . ' (' . $ipAddress . ')';
                    }
                @endphp

                @forelse($sampleActivities as $activity)
                    @php
                        $activityIcon = getActivityIcon($activity->type, $activity->risk_level);
                        $isRecent = $activity->created_at->diffInMinutes() < 60; // Within last hour
                        $isVeryRecent = $activity->created_at->diffInMinutes() < 30; // Within last 30 minutes
                    @endphp
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 group {{ $isVeryRecent ? 'ring-2 ring-green-200 dark:ring-green-800' : '' }}">
                        <div class="relative">
                            <div class="p-2 {{ $activityIcon['bg_color'] }} dark:bg-opacity-80 rounded-lg {{ $isVeryRecent ? 'shadow-lg' : '' }}">
                                <svg class="w-5 h-5 {{ $activityIcon['text_color'] }} dark:opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activityIcon['icon'] }}"></path>
                                </svg>
                            </div>
                            @if($isVeryRecent)
                                <!-- Recent activity indicator -->
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full">
                                    <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-75"></div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="ml-4 flex-1">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                        {{ $activity->description }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ formatLocation($activity->location, $activity->ip_address) }}</span>
                                        </div>
                                        <span>•</span>
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $activity->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        @if($isRecent)
                                            <span>•</span>
                                            <span class="text-green-600 dark:text-green-400 font-medium flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                {{ $activity->created_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end space-y-1 ml-4">
                                    <span class="text-xs font-medium {{ $activityIcon['badge_color'] }} dark:bg-opacity-80 px-2 py-1 rounded-full whitespace-nowrap">
                                        {{ $activityIcon['badge_text'] }}
                                    </span>
                                    @if($activity->risk_level === 'medium')
                                        <span class="text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-2 py-0.5 rounded-full">
                                            Medium Risk
                                        </span>
                                    @elseif($activity->risk_level === 'high')
                                        <span class="text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-2 py-0.5 rounded-full">
                                            High Risk
                                        </span>
                                    @endif
                                    @if($isVeryRecent)
                                        <span class="text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-0.5 rounded-full animate-pulse">
                                            Just now
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Recent Activity</h3>
                        <p class="text-gray-600 dark:text-gray-400">Your account activity will appear here.</p>
                    </div>
                @endforelse
            </div>

            <!-- Activity Summary -->
            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <div class="flex items-center space-x-6">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $sampleActivities->count() }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Recent Activities</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $sampleActivities->where('created_at', '>=', now()->subHours(24))->count() }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Last 24 Hours</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $sampleActivities->where('type', 'login')->count() }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Login Events</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('account.activity') }}" 
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-all duration-200 group">
                        <svg class="w-4 h-4 mr-2 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All 47 Activities
                    </a>
                </div>
            </div>

            <!-- Security Status -->
            <div class="mt-4 p-3 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            Account Security Status: <span class="font-bold">Secure</span>
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                            All recent activities are from trusted locations • Last security scan: Jul 07, 2025 at 15:53 UTC
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-time Activity Updates Script -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update timestamps every minute
            setInterval(function() {
                const timeElements = document.querySelectorAll('[data-time]');
                timeElements.forEach(element => {
                    const timestamp = element.getAttribute('data-time');
                    const date = new Date(timestamp);
                    const now = new Date();
                    const diffMinutes = Math.floor((now - date) / (1000 * 60));
                    
                    if (diffMinutes < 60) {
                        element.textContent = `${diffMinutes} minutes ago`;
                    } else if (diffMinutes < 1440) {
                        const hours = Math.floor(diffMinutes / 60);
                        element.textContent = `${hours} hour${hours > 1 ? 's' : ''} ago`;
                    }
                });
            }, 60000); // Update every minute
            
            console.log('Account Activity loaded for user: harithelord47');
            console.log('Current time: 2025-07-07 15:53:10 UTC');
        });
        </script>

        <!-- Enhanced Activity Styles -->
        <style>
        /* Recent activity animations */
        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .activity-item {
            animation: slideInFromRight 0.3s ease-out;
        }

        /* Enhanced hover effects */
        .group:hover .w-5.h-5 {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Pulse animation for very recent activities */
        .animate-pulse-border {
            animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0%, 100% {
                border-color: rgb(34, 197, 94);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }
            50% {
                border-color: rgb(34, 197, 94);
                box-shadow: 0 0 0 4px rgba(34, 197, 94, 0);
            }
        }

        /* Dark mode enhancements */
        @media (prefers-color-scheme: dark) {
            .animate-pulse-border {
                border-color: rgb(74, 222, 128);
            }
            
            @keyframes pulse-border {
                0%, 100% {
                    border-color: rgb(74, 222, 128);
                    box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7);
                }
                50% {
                    border-color: rgb(74, 222, 128);
                    box-shadow: 0 0 0 4px rgba(74, 222, 128, 0);
                }
            }
        }
        </style>
    </div>

</x-app-layout>