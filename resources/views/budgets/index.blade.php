<x-app-layout>
    <x-slot name="title">
        {{ __('Budgets') }} - {{ config('app.name', 'budgets') }}
    </x-slot>

    <div class=" bg-white p-6 rounded-2xl shadow flex flex-col justify-between"
        style="height: 93vh; overflow: auto;">

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
                        <span class="text-gray-700">Budgets</span>
                    </li>
                </ol>
            </nav>

            <!-- Create Button -->
            <a href="{{ route('budgets.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 shadow">
                <svg class="w-5 h-5 sm:w-4 sm:h-4 mr-0 sm:mr-1 md:mr-1" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden md:inline">Create</span>
            </a>
        </div>

        <!-- Search & Advanced Filter -->
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

            @php
                $hasFilters =
                    request('search') ||
                    request('filter') ||
                    request('start_date') ||
                    request('end_date') ||
                    request('category') ||
                    request('frequency') ||
                    request('roll_over');
            @endphp

            <a href="{{ route('budgets.index') }}"
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
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                    @keydown.escape.window="showFilterForm = false">

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
                        <form method="GET" id="budget-filter-form" class="space-y-4">
                            <!-- Quick Filter -->
                            <div class="mb-4">
                                <label class="text-sm text-gray-600 block mb-1">Quick Filter</label>
                                <select name="filter"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                    <option value="">All</option>
                                    <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="expired" {{ request('filter') == 'expired' ? 'selected' : '' }}>
                                        Expired</option>
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

                            <!-- Category Filter -->
                            <div class="mb-4">
                                <label class="text-sm text-gray-600 block mb-1">Category</label>
                                <select name="category"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Frequency Filter -->
                            <div class="mb-4">
                                <label class="text-sm text-gray-600 block mb-1">Frequency</label>
                                <select name="frequency"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                    <option value="">All</option>
                                    <option value="monthly"
                                        {{ request('frequency') == 'monthly' ? 'selected' : '' }}>Monthly
                                    </option>
                                    <option value="weekly"
                                        {{ request('frequency') == 'weekly' ? 'selected' : '' }}>Weekly
                                    </option>
                                    <option value="yearly"
                                        {{ request('frequency') == 'yearly' ? 'selected' : '' }}>Yearly
                                    </option>
                                </select>
                            </div>

                            <!-- Roll Over Filter -->
                            <div class="mb-4">
                                <label class="text-sm text-gray-600 block mb-1">Roll Over</label>
                                <select name="roll_over"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-800 focus:ring-blue-100 focus:border-blue-500">
                                    <option value="">All</option>
                                    <option value="1" {{ request('roll_over') === '1' ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0" {{ request('roll_over') === '0' ? 'selected' : '' }}>No
                                    </option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center justify-between pt-2">
                                <a href="{{ route('budgets.index') }}"
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

        <!-- Scrollable Table Area -->
        <div class="overflow-auto flex-1">
            <table class="w-full text-sm text-left text-gray-700 bg-white">
                <thead class="text-xs uppercase bg-gray-100 text-gray-600">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Start Date</th>
                        <th class="px-4 py-2">End Date</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($budgets as $budget)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $budget->category->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">₹{{ number_format($budget->amount, 2) }}</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($budget->start_date)->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($budget->end_date)->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('budgets.show', $budget->id) }}"
                                    class="text-yellow-600 hover:underline">View</a>
                                <a href="{{ route('budgets.edit', $budget->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Delete this budget?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-400">No budgets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            <x-pagination :paginator="$budgets" />
        </div>
    </div>
    
</x-app-layout>
