<div class="sm:ml-64">
    <div class="w-full mx-auto max-w-7xl rounded-2xl m-4 flex flex-col justify-between">

        <!-- Admin Dashboard Welcome Message -->
        <div class="p-6 mb-6 text-center text-white rounded-lg shadow-lg bg-gradient-to-r from-blue-500 to-indigo-600">
            <h1 class="text-3xl font-bold">
                Welcome Admin! {{ auth()->user()->name }}!
            </h1>
            <p class="mt-2 text-lg">Here’s your admin dashboard.</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <x-summary-card title="Total Users" value="{{ $totalUsers }}" color="blue" />
            <x-summary-card title="Recently Registered Users" value="{{ $recentlyRegisteredUsers->count() }}"
                color="green" />
            <x-summary-card title="Total Opened Support Tickets" value="{{ $totalOpenedSupportTickets }}"
                color="red" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Recently Registered Users Table -->
            <div class="bg-white shadow rounded-lg p-6 mb-8 sm:col-span-2 overflow-x-auto">
                <h3 class="text-xl font-semibold p-4 border-b">Recently Registered Users</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registered At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentlyRegisteredUsers->slice(0, 5) as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow rounded-lg p-6 mb-8 sm:col-span-1">
                <h3 class="text-xl font-semibold p-4 border-b">Most Used Currencies</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach ($mostUsedCurrencies as $currency)
                        <li class="px-6 py-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $currency->name }}</p>
                                <p class="text-sm text-gray-500">{{ $currency->code }}</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $currency->count }} wallets
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow rounded-lg p-6 mb-8 sm:col-span-2">
                <h3 class="text-xl font-semibold p-4 border-b">Support Tickets</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach ($supportTickets as $ticket)
                        <li class="px-6 py-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $ticket->subject }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $ticket->status }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white shadow rounded-lg p-6 mb-8 sm:col-span-2">
                <h3 class="text-xl font-semibold p-4 border-b">Inactive Users</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach ($inactiveUsers as $user)
                        <li class="px-6 py-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Inactive
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
