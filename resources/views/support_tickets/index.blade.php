<x-app-layout>
    <x-slot name="title">
        {{ __('Support') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-4 rounded-2xl shadow m-4 flex flex-col justify-between"
            style="height: 88vh;">

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
                        sm:px-4 sm:py-2 sm:text-sm
                        px-2 py-2 text-base sm:text-sm"
                    title="Create">
                    <svg class="w-5 h-5 sm:w-4 sm:h-4 mr-0 sm:mr-1" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden sm:inline">Create</span>
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" class="relative w-full sm:w-1/2 mb-4 mx-auto flex items-center">
                <!-- Lens Icon (left) -->
                <span class="absolute left-4 text-gray-500 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ..."
                    class="w-full rounded-full border border-gray-300 bg-white py-2.5 pl-14 pr-10 text-l text-gray-900 shadow-sm focus:ring-blue-100 focus:border-blue-400"
                    id="searchInput" autocomplete="off" />
                @if (request('search'))
                    <!-- Reset (close) icon, only show if search is not empty -->
                    <a href="{{ route('roles.index') }}"
                        class="absolute right-1.5 top-1.3 text-gray-400 hover:bg-gray-200 rounded-full p-1 hover:text-red-500 cursor-pointer"
                        title="Clear search">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </form>

            <!-- Scrollable Table Area -->
            <div class="overflow-auto flex-1">
                @forelse ($supportTickets as $supportTicket)
                    <div
                        class="bg-white border border-gray-200 shadow-sm rounded-xl mb-5 p-5 transition hover:shadow-md">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3 gap-2">
                            <h3 class="text-xl font-bold text-gray-800 line-clamp-1">
                                Ticket #{{ $supportTicket->id }} @if (Auth::user()->hasRole('admin'))
                                    <span class="text-sm text-gray-500">({{ $supportTicket->user->name }})</span>
                                @endif
                            </h3>
                            <div  class="flex flex-col items-end gap-4 text-gray-500 text-sm">
                                <span class="text-sm text-gray-400 whitespace-nowrap">
                                    Updated {{ $supportTicket->updated_at->diffForHumans() }}</span>
                                @if ($supportTicket->status === 'opened')
                                    <span class="bg-green-100 text-green-800 font-semibold px-2 py-1 rounded">
                                        Open
                                    </span>
                                @elseif ($supportTicket->status === 'closed')
                                    <span class="bg-red-100 text-red-800 font-semibold px-2 py-1 rounded">
                                        Closed
                                    </span>
                                @elseif ($supportTicket->status === 'admin_replied')
                                    <span class="bg-blue-100 text-blue-800 font-semibold px-2 py-1 rounded">
                                        Admin Replied
                                    </span>
                                @elseif ($supportTicket->status === 'customer_replied')
                                    <span class="bg-yellow-100 text-yellow-800 font-semibold px-2 py-1 rounded">
                                        User Replied
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 font-semibold px-2 py-1 rounded">
                                        Unknown
                                    </span>
                                @endif
                            </div>
                        </div>

                        <p class="text-gray-600 mb-3 line-clamp-2">
                            {{ $supportTicket->subject }}
                        </p>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('support_tickets.show', $supportTicket) }}"
                                class="inline-flex items-center text-blue-600 font-medium hover:underline hover:text-blue-700 transition">
                                View Details
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 border border-gray-200 shadow rounded-lg p-6 text-center text-gray-500">
                        No support tickets found.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                <x-pagination :paginator="$supportTickets" />
            </div>
        </div>
    </div>
</x-app-layout>
