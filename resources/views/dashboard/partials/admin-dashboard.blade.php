
<div class="space-y-6">

    <!-- Enhanced Admin Welcome Section -->
    <div class="overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-700 to-blue-800 rounded-2xl shadow-2xl">
        {{-- <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="absolute -top-8 -right-8 w-40 h-40 bg-white opacity-5 rounded-full"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white opacity-5 rounded-full"></div> --}}
        <div class="p-8 text-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl lg:text-4xl font-bold">
                            Welcome Admin, {{ auth()->user()->name }}!
                        </h1>
                    </div>
                    <p class="text-indigo-100 text-lg">
                        Manage your platform with complete control and insights
                    </p>
                </div>
                <div class="rounded-xl p-4 min-w-max" style="background-color: rgba(255, 255, 255, 0.2)">
                    <div class="text-right">
                        <p class="text-sm text-indigo-100 mb-1">System Status</p>
                        <div class="flex items-center justify-end space-x-2 mb-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-sm font-semibold">All Systems Operational</span>
                        </div>
                        <p class="text-xs text-indigo-200" id="currentDateTime"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Users Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-100 rounded-xl group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Platform</p>
                            <p class="text-lg font-bold text-gray-900">Total Users</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Active
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($totalUsers) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Registered users</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('user.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            Manage
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r from-blue-400 to-blue-600"></div>
        </div>

        <!-- Recent Registrations Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Recent</p>
                            <p class="text-lg font-bold text-gray-900">New Users</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ↗ Growing
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-green-600">{{ $recentlyRegisteredUsers->count() }}</p>
                        <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
                    </div>
                    <div class="text-right">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r from-green-400 to-green-600"></div>
        </div>

        <!-- Support Tickets Card -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-red-100 rounded-xl group-hover:bg-red-200 transition-colors">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Open</p>
                            <p class="text-lg font-bold text-gray-900">Support Tickets</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ $totalOpenedSupportTickets > 5 ? 'High' : 'Normal' }}
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-red-600">{{ $totalOpenedSupportTickets }}</p>
                        <p class="text-sm text-gray-500 mt-1">Needs attention</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('support_tickets.index') }}" class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center">
                            Review
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="h-2 bg-gradient-to-r from-red-400 to-red-600"></div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recently Registered Users - Takes 2 columns -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Recently Registered Users
                    </h3>
                    <a href="{{ route('user.index') }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                        View All Users
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">User</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Email</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Registration</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($recentlyRegisteredUsers->slice(0, 5) as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                                <p class="text-sm text-gray-500">ID: #{{ $user->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <p class="text-sm text-gray-900">{{ $user->email }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ✓ Active
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            <p class="text-gray-500 font-medium">No recent registrations</p>
                                            <p class="text-gray-400 text-sm">New user registrations will appear here</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Most Used Currencies Widget -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Popular Currencies
                </h3>
            </div>
            <div class="p-6 space-y-4">
                @forelse ($mostUsedCurrencies as $index => $currency)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">#{{ $index + 1 }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $currency->name }}</p>
                                <p class="text-sm text-gray-500">{{ $currency->code }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                {{ $currency->count }} wallets
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">No currency data</p>
                        <p class="text-gray-400 text-sm">Currency usage will appear here</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Support Tickets -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Recent Support Tickets
                    </h3>
                    <a href="{{ route('support_tickets.index') }}" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                        Manage All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @forelse ($supportTickets as $ticket)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 {{ $ticket->status === 'open' ? 'bg-red-400' : ($ticket->status === 'pending' ? 'bg-yellow-400' : 'bg-green-400') }} rounded-full"></div>
                            <div> 
                                <p class="font-semibold text-gray-900 text-sm">{{ Str::limit($ticket->subject, 30) }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $ticket->status === 'open' ? 'bg-red-100 text-red-800' : 
                                ($ticket->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">No support tickets</p>
                        <p class="text-gray-400 text-sm">All good! No pending support requests</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Inactive Users -->
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Inactive Users
                    </h3>
                    <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $inactiveUsers->count() }} users
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @forelse ($inactiveUsers as $user)
                    <div class="flex items-center justify-between p-4 bg-orange-50 border border-orange-200 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                ⏸ Inactive
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">All users are active</p>
                        <p class="text-gray-400 text-sm">Great engagement across the platform!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

<script>
    // Update current date and time
    function updateDateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };
        document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
    }
    
    // Update immediately and then every minute
    updateDateTime();
    setInterval(updateDateTime, 60000);
</script>