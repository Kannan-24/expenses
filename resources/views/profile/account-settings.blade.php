<x-app-layout>
    <x-slot name="title">
        {{ __('Account Settings') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class=" space-y-6" style="min-height: 88vh;">

        <!-- Enhanced Header Section -->
        <div class="relative bg-gradient-to-br from-gray-800 via-gray-900 to-black rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute -top-8 -right-8 w-40 h-40 bg-white opacity-5 rounded-full"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white opacity-5 rounded-full"></div>
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold">Account Settings</h1>
                                <p class="text-gray-300 text-lg mt-1">Manage your account security and preferences</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Info Card -->
                    <div class="mt-4 lg:mt-0 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            @if (Auth::user()->profile_photo)
                                <img class="w-12 h-12 rounded-full object-cover ring-2 ring-white ring-opacity-30" 
                                     src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" />
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center ring-2 ring-white ring-opacity-30">
                                    <span class="text-white font-bold text-lg">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="text-white font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-gray-300 text-sm">{{ Auth::user()->email }}</p>
                                <p class="text-gray-400 text-xs">Last login: {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Security Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Account Status</p>
                        <p class="text-lg font-bold text-green-600">Active & Secure</p>
                        <p class="text-xs text-gray-500 mt-1">Account verified</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Password Strength</p>
                        <p class="text-lg font-bold text-blue-600">Strong</p>
                        <p class="text-xs text-gray-500 mt-1">Last updated: {{ Auth::user()->updated_at->format('M d, Y') }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Account Age</p>
                        <p class="text-lg font-bold text-purple-600">{{ Auth::user()->created_at->diffForHumans(null, true) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Settings Content -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            
            <!-- Password Update Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Password Security</h2>
                            <p class="text-sm text-gray-600 mt-1">Update your password to keep your account secure</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Account Management Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-200 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Account Management</h2>
                            <p class="text-sm text-gray-600 mt-1">Manage your account settings and data</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    
                    <!-- Quick Actions -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">Edit Profile</p>
                                    <p class="text-xs text-gray-600">Update your personal information</p>
                                </div>
                            </a>
                            
                            <button class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                                <div class="p-2 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">Verify Account</p>
                                    <p class="text-xs text-gray-600">Complete account verification</p>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Delete Account Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Danger Zone</h3>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Settings Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Additional Settings
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Notification Preferences -->
                <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-300 transition-colors">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Notifications</h3>
                            <p class="text-sm text-gray-600">Manage your notification preferences</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                            <span class="ml-2 text-sm text-gray-700">Email notifications</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">In-app notifications</span>
                        </label>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="p-4 border border-gray-200 rounded-lg hover:border-green-300 transition-colors">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Privacy</h3>
                            <p class="text-sm text-gray-600">Control your privacy settings</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" checked>
                            <span class="ml-2 text-sm text-gray-700">Profile visibility</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" checked>
                            <span class="ml-2 text-sm text-gray-700">Data analytics</span>
                        </label>
                    </div>
                </div>

                <!-- Security Options -->
                <div class="p-4 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Security</h3>
                            <p class="text-sm text-gray-600">Enhanced security options</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Two-factor authentication</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50" checked>
                            <span class="ml-2 text-sm text-gray-700">Login alerts</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Activity Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Recent Account Activity
                </h2>
                <a href="{{ route('account.activity') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View All
                </a>
            </div>
        
            <div class="space-y-4">
                @forelse(auth()->user()->recentActivities(5)->get() as $activity)
                    @php
                        $activityIcon = $activity->activity_icon;
                    @endphp
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="p-2 {{ $activityIcon['bg_color'] }} rounded-lg">
                            <svg class="w-5 h-5 {{ $activityIcon['text_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activityIcon['icon'] }}"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $activity->description }}</p>
                            <div class="flex items-center space-x-2 text-xs text-gray-600 mt-1">
                                <span>{{ $activity->formatted_location }}</span>
                                <span>•</span>
                                <span>{{ $activity->created_at->format('M d, Y H:i') }}</span>
                                @if($activity->created_at->diffInHours() < 24)
                                    <span>•</span>
                                    <span class="text-green-600 font-medium">{{ $activity->created_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="text-xs font-medium {{ $activityIcon['badge_color'] }} px-2 py-1 rounded-full">
                            {{ $activityIcon['badge_text'] }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Recent Activity</h3>
                        <p class="text-gray-600">Your account activity will appear here.</p>
                    </div>
                @endforelse
            </div>
        
            @if(auth()->user()->activities()->count() > 5)
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('account.activity') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All {{ auth()->user()->activities()->count() }} Activities
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>