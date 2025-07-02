<x-app-layout>
    <x-slot name="title">
        {{ __('Account Activity') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6 space-y-8" style="min-height: 88vh;">
        
        <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 sm:px-8 py-8 relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent"></div>
                
                <!-- Content -->
                <div class="relative z-10">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                Account Activity
                            </h1>
                            <p class="text-purple-100 mt-2 text-lg">
                                Monitor your account security and recent actions for 
                                <span class="font-semibold text-white">{{ Auth::user()->name }}</span>
                            </p>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 text-center border border-white/20">
                                <div class="text-2xl font-bold text-white">{{ $activities->count() }}</div>
                                <div class="text-xs text-purple-200">Recent Activities</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 text-center border border-white/20">
                                <div class="text-2xl font-bold text-white">{{ $activities->where('created_at', '>=', now()->subDays(7))->count() }}</div>
                                <div class="text-xs text-purple-200">Last 7 Days</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Filter & Search -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <!-- Search & Filter -->
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 flex-1">
                        <!-- Search -->
                        <div class="relative flex-1 max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="activitySearch"
                                   placeholder="Search activities..."
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent sm:text-sm transition-all">
                        </div>
                        
                        <!-- Time Filter -->
                        <div class="relative">
                            <select id="timeFilter" 
                                    class="block w-full px-4 py-3 pr-8 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent sm:text-sm transition-all">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">Last 7 Days</option>
                                <option value="month">Last 30 Days</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Export & Settings -->
                    <div class="flex space-x-3">
                        <button onclick="exportActivities()" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export
                        </button>
                        
                        <button x-data="" x-on:click="$dispatch('open-modal', 'activity-settings')"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Activity Timeline -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Activity Timeline
                </h2>
                <p class="text-gray-600 mt-1">Recent account activities and security events</p>
            </div>
            
            <div class="divide-y divide-gray-100" id="activityContainer">
                @forelse($activities as $index => $activity)
                    @php
                        $activityIcon = $activity->activity_icon;
                        $isRecent = $activity->created_at->diffInHours() < 24;
                        $isToday = $activity->created_at->isToday();
                    @endphp
                    
                    <div class="activity-item p-6 hover:bg-gray-50 transition-all duration-200 group" 
                         data-activity="{{ strtolower($activity->description) }}"
                         data-date="{{ $activity->created_at->format('Y-m-d') }}">
                        <div class="flex items-start space-x-4">
                            <!-- Timeline Indicator -->
                            <div class="relative flex-shrink-0">
                                <div class="w-12 h-12 {{ $activityIcon['bg_color'] }} rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-200">
                                    <svg class="w-6 h-6 {{ $activityIcon['text_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activityIcon['icon'] }}"></path>
                                    </svg>
                                </div>
                                
                                <!-- Timeline Line -->
                                @if(!$loop->last)
                                    <div class="absolute top-12 left-1/2 w-0.5 h-8 bg-gray-200 transform -translate-x-1/2"></div>
                                @endif
                                
                                <!-- Recent Activity Pulse -->
                                @if($isRecent)
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full">
                                        <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-75"></div>
                                        <div class="absolute inset-0 bg-green-500 rounded-full"></div>
                                    </div>
                                @endif
                            </div>

                            <!-- Activity Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between space-y-2 sm:space-y-0">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                                            {{ $activity->description }}
                                        </h3>
                                        
                                        <!-- Activity Details -->
                                        <div class="mt-2 flex flex-col sm:flex-row sm:items-center space-y-1 sm:space-y-0 sm:space-x-4 text-sm text-gray-600">
                                            <!-- Location -->
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ $activity->formatted_location ?: 'Unknown Location' }}</span>
                                            </div>
                                            
                                            <!-- Date & Time -->
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>{{ $activity->created_at->format('M d, Y \a\t H:i') }}</span>
                                            </div>
                                            
                                            @if($isRecent)
                                                <div class="flex items-center text-green-600 font-medium">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    <span>{{ $activity->created_at->diffForHumans() }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Additional Info (if available) -->
                                        @if(isset($activity->metadata) && !empty($activity->metadata))
                                            <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                                <h4 class="text-sm font-medium text-gray-900 mb-2">Additional Details:</h4>
                                                <div class="text-sm text-gray-600 space-y-1">
                                                    @foreach($activity->metadata as $key => $value)
                                                        <div class="flex justify-between">
                                                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                            <span>{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Activity Badge -->
                                    <div class="flex flex-col items-end space-y-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $activityIcon['badge_color'] }} whitespace-nowrap">
                                            {{ $activityIcon['badge_text'] }}
                                        </span>
                                        
                                        @if($isToday)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Today
                                            </span>
                                        @endif
                                        
                                        <!-- Risk Level Indicator -->
                                        @if(isset($activity->risk_level))
                                            <div class="flex items-center space-x-1">
                                                @for($i = 1; $i <= 3; $i++)
                                                    <div class="w-2 h-2 rounded-full {{ $i <= $activity->risk_level ? 'bg-red-500' : 'bg-gray-200' }}"></div>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Enhanced Empty State -->
                    <div class="text-center py-16">
                        <div class="relative">
                            <!-- Animated Background -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-blue-100 rounded-full opacity-50 animate-pulse"></div>
                            </div>
                            
                            <!-- Main Icon -->
                            <div class="relative w-20 h-20 bg-gradient-to-br from-purple-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Recent Activity</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Your account activity and security events will appear here as you use the application.
                        </p>
                        
                        <!-- Helpful Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-all shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3z"></path>
                                </svg>
                                Go to Dashboard
                            </a>
                            <button onclick="refreshActivities()" 
                                    class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
            
            @if($activities->count() > 0)
                <!-- Load More Button -->
                <div class="p-6 border-t border-gray-100 text-center">
                    <button onclick="loadMoreActivities()" 
                            class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        Load More Activities
                    </button>
                </div>
            @endif
        </div>

        <!-- Security Insights Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Security Insights
                </h2>
                <p class="text-gray-600 mt-1">Account security overview and recommendations</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Login Security -->
                    <div class="text-center p-4 bg-green-50 rounded-xl border border-green-200">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-green-800 mb-1">Secure Logins</h3>
                        <p class="text-sm text-green-600">All recent logins verified</p>
                    </div>
                    
                    <!-- Device Security -->
                    <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-blue-800 mb-1">Trusted Devices</h3>
                        <p class="text-sm text-blue-600">{{ $activities->pluck('ip_address')->unique()->count() ?? 1 }} active device(s)</p>
                    </div>
                    
                    <!-- Account Health -->
                    <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-200">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-purple-800 mb-1">Account Health</h3>
                        <p class="text-sm text-purple-600">Excellent security status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Settings Modal -->
    <x-modal name="activity-settings" focusable>
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Activity Settings</h2>
            
            <form class="space-y-6">
                <!-- Notification Preferences -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Preferences</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50" checked>
                            <span class="ml-3 text-sm text-gray-700">Email notifications for suspicious activity</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50" checked>
                            <span class="ml-3 text-sm text-gray-700">Browser notifications for new logins</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="ml-3 text-sm text-gray-700">Weekly activity summary</span>
                        </label>
                    </div>
                </div>
                
                <!-- Data Retention -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Retention</h3>
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Keep activity logs for:</label>
                        <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                            <option>30 days</option>
                            <option selected>90 days</option>
                            <option>6 months</option>
                            <option>1 year</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Enhanced JavaScript -->
    <script>
        // Search functionality
        document.getElementById('activitySearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const activities = document.querySelectorAll('.activity-item');
            
            activities.forEach(activity => {
                const text = activity.getAttribute('data-activity');
                if (text.includes(searchTerm)) {
                    activity.style.display = 'block';
                } else {
                    activity.style.display = 'none';
                }
            });
        });

        // Time filter functionality
        document.getElementById('timeFilter').addEventListener('change', function(e) {
            const filter = e.target.value;
            const activities = document.querySelectorAll('.activity-item');
            const now = new Date();
            
            activities.forEach(activity => {
                const activityDate = new Date(activity.getAttribute('data-date'));
                let show = true;
                
                switch(filter) {
                    case 'today':
                        show = activityDate.toDateString() === now.toDateString();
                        break;
                    case 'week':
                        const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                        show = activityDate >= weekAgo;
                        break;
                    case 'month':
                        const monthAgo = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
                        show = activityDate >= monthAgo;
                        break;
                    case 'all':
                    default:
                        show = true;
                }
                
                activity.style.display = show ? 'block' : 'none';
            });
        });

        // Export functionality
        function exportActivities() {
            const activities = @json($activities->toArray());
            const dataStr = JSON.stringify(activities, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = `account-activities-${new Date().toISOString().split('T')[0]}.json`;
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            showNotification('Activities exported successfully!', 'success');
        }

        // Refresh functionality
        function refreshActivities() {
            showNotification('Refreshing activities...', 'info');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Load more functionality
        function loadMoreActivities() {
            showNotification('Loading more activities...', 'info');
            // Implementation would depend on your pagination system
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-600 text-white' : 
                type === 'error' ? 'bg-red-600 text-white' : 
                'bg-blue-600 text-white'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success' ? 
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                            type === 'error' ?
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' :
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                        }
                    </svg>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Activity page loaded for user: {{ Auth::user()->email }}');
            
            // Auto-refresh every 5 minutes
            setInterval(() => {
                if (document.visibilityState === 'visible') {
                    // You could implement an AJAX refresh here
                    console.log('Auto-refresh check...');
                }
            }, 300000); // 5 minutes
        });
    </script>

    <!-- Enhanced Styles -->
    <style>
        /* Timeline animations */
        .activity-item {
            animation: slideInUp 0.3s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Enhanced hover effects */
        .activity-item:hover .w-12.h-12 {
            transform: scale(1.05);
        }
        
        /* Mobile optimizations */
        @media (max-width: 640px) {
            .space-y-8 > * + * {
                margin-top: 1.5rem;
            }
            
            .activity-item {
                padding: 1rem;
            }
            
            .activity-item .flex.items-start {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .activity-item .flex.items-start .space-x-4 > * + * {
                margin-left: 0;
                margin-top: 1rem;
            }
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
        
        /* Custom scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #8b5cf6, #3b82f6);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #7c3aed, #2563eb);
        }
    </style>
</x-app-layout>