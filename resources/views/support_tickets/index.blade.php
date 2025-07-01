<x-app-layout>
    <x-slot name="title">
        {{ __('Support') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-4 rounded-2xl shadow m-4 flex flex-col justify-between"
            style="height: 88vh; overflow: auto;">

            <!-- Breadcrumb & Create Button -->
            <div class="flex justify-between items-center mb-3">
                <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Support</span>
                        </li>
                    </ol>
                </nav>

                <!-- Create Button -->
                <a href="{{ route('support_tickets.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 shadow
                        sm:px-4 sm:py-2 sm:text-sm"
                    title="Create">
                    <svg class="w-5 h-5 sm:w-4 sm:h-4 mr-0 sm:mr-1" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">Create</span>
                </a>
            </div>

            <!-- Filters -->
            <form method="GET"
                class="w-full sm:max-w-screen-sm mb-4 mx-auto flex items-center gap-2 bg-white border border-gray-300 rounded-full px-3 py-1 shadow-sm">
                <!-- Lens Icon (left) -->
                <span class="text-gray-500 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </span>

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ..."
                    class="flex-grow border-0 focus:ring-0 focus:outline-none text-base text-gray-900 bg-transparent"
                    id="searchInput" autocomplete="off" />

                <!-- Show X mark if any filter/search is applied -->
                @php
                    $hasFilters =
                        request('search') || request('filter') || request('start_date') || request('end_date');
                @endphp

                <a href="{{ route('support_tickets.index') }}"
                    class="text-gray-400 hover:text-red-500 p-1 transition
                    {{ $hasFilters ? '' : 'pointer-events-none' }}"
                    title="Clear filters and search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>


                <!-- Advanced Search Button (right) -->
                <div class="text-gray-600 hover:text-blue-600 p-1 transition" x-data="{ showFilterForm: false }">
                    <button type="button" @click="showFilterForm = true"
                        class="flex items-center justify-center h-9 w-9 rounded-full hover:bg-gray-200 hover:text-white transition"
                        title="Advanced Search">
                        <svg viewBox="0 0 600 600" class="h-5 w-5">
                            <g>
                                <g>
                                    <g>
                                        <path
                                            style="color:#888888;fill:#888888;stroke-linecap:round;-inkscape-stroke:none"
                                            d="M 447.70881 -12.781343 A 42.041451 42.041451 0 0 0 405.66786 29.260344 L 405.66786 50.301721 L 27.434765 50.301721 A 42.041302 42.041302 0 0 0 -14.606185 92.341354 A 42.041302 42.041302 0 0 0 27.434765 134.38304 L 405.66786 134.38304 L 405.66786 155.44906 A 42.041451 42.041451 0 0 0 447.70881 197.49075 A 42.041451 42.041451 0 0 0 489.74976 155.44906 L 489.74976 134.38304 L 573.78036 134.38304 A 42.041302 42.041302 0 0 0 615.82336 92.341354 A 42.041302 42.041302 0 0 0 573.78036 50.301721 L 489.74976 50.301721 L 489.74976 29.260344 A 42.041451 42.041451 0 0 0 447.70881 -12.781343 z M 143.0012 197.48869 A 42.041451 42.041451 0 0 0 100.9582 239.53038 L 100.9582 260.5697 L 27.447078 260.5697 A 42.041302 42.041302 0 0 0 -14.593872 302.61139 A 42.041302 42.041302 0 0 0 27.447078 344.65308 L 100.9582 344.65308 L 100.9582 365.7191 A 42.041451 42.041451 0 0 0 143.0012 407.76078 A 42.041451 42.041451 0 0 0 185.04215 365.7191 L 185.04215 344.65308 L 573.79472 344.65308 A 42.041302 42.041302 0 0 0 615.83567 302.61139 A 42.041302 42.041302 0 0 0 573.79472 260.5697 L 185.04215 260.5697 L 185.04215 239.53038 A 42.041451 42.041451 0 0 0 143.0012 197.48869 z M 279.59427 407.76078 A 42.041451 42.041451 0 0 0 237.55332 449.80042 L 237.55332 470.83974 L 27.447078 470.83974 A 42.041302 42.041302 0 0 0 -14.593872 512.88143 A 42.041302 42.041302 0 0 0 27.447078 554.92106 L 237.55332 554.92106 L 237.55332 575.98913 A 42.041451 42.041451 0 0 0 279.59427 618.02877 A 42.041451 42.041451 0 0 0 321.63522 575.98913 L 321.63522 554.92106 L 573.79472 554.92106 A 42.041302 42.041302 0 0 0 615.83567 512.88143 A 42.041302 42.041302 0 0 0 573.79472 470.83974 L 321.63522 470.83974 L 321.63522 449.80042 A 42.041451 42.041451 0 0 0 279.59427 407.76078 z ">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </button>

                    <!-- Popup Modal (Hidden by default) -->
                    <div x-show="showFilterForm" x-cloak
                        class="fixed inset-0 z-0 flex items-center justify-center bg-black/50 p-4"
                        @keydown.escape.window="showModal = false">

                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6"
                            @click.away="showFilterForm = false">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">Advanced Search</h2>
                                <button @click="showFilterForm = false" class="text-gray-600 hover:text-red-600"
                                    type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Filter Form -->
                            <form method="GET" id="support-ticket-filter-form" class="space-y-4">
                                <!-- Quick Filter -->
                                <div class="mb-4">
                                    <label class="text-sm text-gray-600 block mb-1">Quick Filter</label>
                                    <select name="filter"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                        <option value="">All</option>
                                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last
                                            7 Days</option>
                                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>
                                            Last 15 Days</option>
                                        <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>
                                            Last 1 Month</option>
                                    </select>
                                </div>

                                <!-- Start Date -->
                                <div class="mb-4">
                                    <label class="text-sm text-gray-600 block mb-1">Start Date</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500" />
                                </div>

                                <!-- End Date -->
                                <div class="mb-4">
                                    <label class="text-sm text-gray-600 block mb-1">End Date</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500" />
                                </div>

                                <!-- Status Filter -->
                                <div class="mb-4">
                                    <label class="text-sm text-gray-600 block mb-1">Status</label>
                                    <select name="status"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                        <option value="">All Statuses</option>
                                        <option value="opened" {{ request('status') == 'opened' ? 'selected' : '' }}>
                                            Opened</option>
                                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>
                                            Closed</option>
                                        <option value="admin_replied"
                                            {{ request('status') == 'admin_replied' ? 'selected' : '' }}>Admin Replied
                                        </option>
                                        <option value="customer_replied"
                                            {{ request('status') == 'customer_replied' ? 'selected' : '' }}>Customer
                                            Replied</option>
                                    </select>
                                </div>

                                <!-- User Filter (only for admin) -->
                                @if (Auth::user()->hasRole('admin'))
                                    <div class="mb-4">
                                        <label class="text-sm text-gray-600 block mb-1">User</label>
                                        <select name="user"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                            <option value="">All Users</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ request('user') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <!-- Buttons -->
                                <div class="flex items-center justify-between pt-2">
                                    <a href="{{ route('support_tickets.index') }}"
                                        class="text-sm text-gray-600 hover:text-gray-800 underline">Reset</a>
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md">
                                        Apply Filters
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>

            <div class="w-full mb-6 mx-auto mt-4 flex items-start">
                <form method="GET" id="showDeletedForm" class="flex items-center w-full">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="checkbox" name="show_deleted" id="show_deleted"
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ request('show_deleted') ? 'checked' : '' }} onchange="this.form.submit()">
                    <label for="show_deleted" class="ml-2 text-sm text-gray-700">Show Deleted Tickets</label>
                </form>
            </div>

            <!-- Scrollable Table Area -->
            <div class="overflow-auto flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse ($supportTickets as $supportTicket)
                        <div
                            class="bg-white border border-gray-200 shadow-sm rounded-xl p-5 transition hover:shadow-md flex flex-col justify-between h-full">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3 gap-2">
                                <h3 class="text-xl font-bold text-gray-800 line-clamp-1">
                                    Ticket #{{ $supportTicket->id }}
                                    @if (Auth::user()->hasRole('admin'))
                                        <span class="text-sm text-gray-500">({{ $supportTicket->user->name }})</span>
                                    @endif
                                </h3>
                                <div class="flex flex-col items-end gap-2 text-gray-500 text-sm">
                                    <span class="text-sm text-gray-400 whitespace-nowrap">
                                        Updated {{ $supportTicket->updated_at->diffForHumans() }}
                                    </span>
                                    @php
                                        $statusClasses = [
                                            'opened' => 'bg-green-100 text-green-800',
                                            'closed' => 'bg-red-100 text-red-800',
                                            'admin_replied' => 'bg-blue-100 text-blue-800',
                                            'customer_replied' => 'bg-yellow-100 text-yellow-800',
                                            'unknown' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $statusLabel = ucfirst(
                                            str_replace('_', ' ', $supportTicket->status ?? 'unknown'),
                                        );
                                        $badgeClass =
                                            $statusClasses[$supportTicket->status] ?? $statusClasses['unknown'];
                                    @endphp
                                    <span class="font-semibold px-2 py-1 rounded {{ $badgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </div>

                            <p class="text-gray-600 mb-3 line-clamp-2">
                                {{ $supportTicket->subject }}
                            </p>

                            <div class="flex justify-between items-center flex-wrap gap-3 mt-auto">
                                <a href="{{ route('support_tickets.show', $supportTicket) }}"
                                    class="inline-flex items-center text-blue-600 font-medium hover:underline hover:text-blue-700 transition">
                                    View Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>

                                <div class="flex flex-wrap gap-2">
                                    {{-- Close Ticket --}}
                                    @if ($supportTicket->status !== 'closed' && !$supportTicket->trashed())
                                        <form method="POST"
                                            action="{{ route('support_tickets.close', $supportTicket) }}">
                                            @csrf
                                            <button type="submit"
                                                class="text-sm px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">
                                                Close
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Open Ticket --}}
                                    @if ($supportTicket->status === 'closed' && !$supportTicket->trashed())
                                        <form method="POST"
                                            action="{{ route('support_tickets.reopen', $supportTicket) }}">
                                            @csrf
                                            <button type="submit"
                                                class="text-sm px-3 py-1 bg-green-100 text-green-800 rounded hover:bg-green-200">
                                                Reopen
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete Ticket --}}
                                    @if (!$supportTicket->trashed())
                                        <form method="POST"
                                            action="{{ route('support_tickets.destroy', $supportTicket) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200"
                                                onclick="return confirm('Are you sure you want to delete this ticket?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Recover Ticket --}}
                                    @if ($supportTicket->trashed() && Auth::user()->hasRole('admin'))
                                        <form method="POST"
                                            action="{{ route('support_tickets.recover', $supportTicket) }}">
                                            @csrf
                                            <button type="submit"
                                                class="text-sm px-3 py-1 bg-green-100 text-green-800 rounded hover:bg-green-200">
                                                Restore
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-gray-50 border border-gray-200 shadow rounded-lg p-6 text-center text-gray-500 col-span-1 sm:col-span-3">
                            No support tickets found.
                        </div>
                    @endforelse
                </div>
            </div>


            <!-- Pagination -->
            <div class="pt-4">
                <x-pagination :paginator="$supportTickets" />
            </div>
        </div>
    </div>
</x-app-layout>
